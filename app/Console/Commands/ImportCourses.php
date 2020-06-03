<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wrsc:import_courses
    {--F|file_name= : the name of the tab delimited file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Course Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->open_file($this->option('file_name'));
        // read file X 
        // update member_type
        // alter join_date
        // Alter renewal_receipt_date
        // Fix up Primary members,  dont set it for primary members 
        // Set up Auths if yes then Yes 
        // Set Up courses  If not null.  look for a date, then add the entire cell to the description
        // Residential address 
    }


    public function open_file($fileName)
    {


        $row = 1;
        if (($handle = fopen("$fileName", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                if ($row == 1) {
                    $row++;
                    continue;
                }
                $row++;
                if (!$data[0]) {
                    continue;
                }
                echo "importing row $row \n";
                $member = \App\Models\BackpackUser::where('member_number', $data[2])->first();
                if (!$member) { 
                    print_r ("unable to find member $data[0] $data[1] member number $data[2]\n");
                    continue;
                }
                $this->addCourses($member, $data);
                $this->addAuthorities($member, $data);
            }
            fclose($handle);
        }
    }

    public function addCourses(\App\Models\BackpackUser $member, array $row)
    {

        //spreadsheet => database
        $courseMappings = [
            38 => 2,
            39 => 3,
            40 => 4,
            41 => 5,
            42 => 6,
            43 => 7,
            44 => 8,
            45 => 9,
            46 => 11,
            47 => 10,
            48 => 12
        ];

        for ($c = 38; $c < 49; $c++) {
            if ($row[$c]) {
                $course = \App\Models\Course::find($courseMappings[$c]);
                $courseUser = new \App\Models\CourseUser;
                $courseUser->course_id = $courseMappings[$c];
                $courseUser->comment = $row[$c];
                $courseUser->date_completed = $this->extractDates($row[$c]);
                $member->courses()->save($courseUser);
            }
        }
    }
    public function addAuthorities(\App\Models\BackpackUser $member, array $row)
    {

        //spreadsheet => database
        $authorityMappings = [
            27 => 1,
            28 => 2,
            30 => 3,
        ];

        foreach ($authorityMappings as $cell => $value) {
            if ($row[$cell] == 'YES') {
                $authorityUser = new \App\Models\AuthoritiesUser;
                $authorityUser->authority_id = $authorityMappings[$cell];
                $member->authorities()->save($authorityUser);
            }
        }
    }
    public function extractDates($string)
    {

        preg_match_all('/(20\d\d)|(\d?\d\/\d?\d\/\d?\d?\d\d)|(Jan|Feb|Mar|Apr|May|June|July|Aug|Sept|Nov|Oct|Dec)/i', $string, $matches);
        if (!$matches) {
            return null;
        }
        $date = date('Y-m-d', 0);
        $year_match = array_filter($matches[1]);
        $year = array_shift($year_match);
        $fullDateMatch = array_filter($matches[2]);
        $full_date = array_shift($fullDateMatch);
        $monthMatch = array_filter($matches[3]);
        $month = array_shift($monthMatch);

        $month_map = ['Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'MAR' => 3, 'Apr' => 4, 'May' => 5, 'June' => 6,  'Jun' => 6, 'July' => 7, 'Jul' => 7, 'Aug' => 8, 'sept' => 9, 'Sept' => 9, 'oct' => 10,  'Oct' => 10, 'Nov' => 11, 'Dec' => 12];
        if ($month && $year) {
            $month = strtolower($month);
            $month = Ucfirst($month);
            $date = "$year-" . $month_map[$month] . "-01";
        } elseif ($year) {

            $date = "$year-01-01";
        }
        if ($full_date) {
            preg_match('/(\d?\d)\/(\d?\d)\/(\d?\d?\d\d)($|\s)/', $full_date, $dateParts);
            if (strlen($date[3]) == 2) {
                $dateParts[3] = '20' . $dateParts[3];
            }
            $date = $dateParts[3] . '-' . $dateParts[2] . "-" . $dateParts[1];
        }
        return $date;
    }
}