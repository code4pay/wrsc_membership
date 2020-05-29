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
    protected $signature = 'wrsc:import
    {--F|file_name= : the name of the tab delimited file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial Import script';

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
        $fieldMappings = [
            'first_name' => 0,
            'last_name' => 1,
            'email' => 9,
            'address' => 10,
            'city' => 11,
            'post_code' => 12,
            'address_residential' => 10,
            'city_residential' => 11,
            'post_code_residential' => 12,
            'member_number' => 2,
            'wildman_number' => 3,
            'mobile' => 14,
            'home_phone' => 15,
            'receipt_number' => 18
        ];

        $regionMapping = [
            'FSC' => 3,
            'Nowra' => 1,
            'Bay & Basin' => 7,
            'bay & Basin' => 7,
            'Highlands' => 5,
            'highlands' => 5,
            'Ulladulla' => 2,
            'Illawarra' => 4,
            'Batemans Bay' => 6
        ];



        $memberTypes = ['P' => 5, 'p' => 5, 'LM' => 3, 'T' => 4, 'F' => 6, 'H' => 7, 'J' => 9, 'LMA' => 3];
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
                $member_type_id = $memberTypes[$data[16]];
                $member = new \App\Models\BackpackUser;
                $member->member_type_id = $member_type_id;
                $password = str_random(50);
                $member->password = Hash::make($password);
                $member->joined = $this->extractDates($data[17]);
                if (isset($regionMapping[$data[13]])) {
                    $member->region_id = $regionMapping[$data[13]];
                }
                if (isset($data[24]) && $data[24]) {
                    $member->lyssa_serology_comment = $data[24];
                    $member->lyssa_serology_date = $this->extractDates($data[24]);

                    preg_match('/(\d+\.\d+)|(?:^|\s|\>)(\d)(?:\s|$)/', $data[24], $level_match);
                    if (isset($level_match[0])) {
                        if (is_numeric($level_match[1])) {
                            $member->lyssa_serology_value = $level_match[1] * 1;
                        } elseif (is_numeric($level_match[2])) {
                            $member->lyssa_serology_value = $level_match[2] * 1;
                        }
                    }
                }
                if (Storage::disk('private')->exists('profile_images/' . $data[2].'.jpg' )){
                    $member->image = 'profile_images/'.$data[2].'.jpg';
                }
                $member->paid_to = $this->extractDates($data[20]);
                $member->receipt_date = $this->extractDates($data[19]);

                $member->addComment($data[37]);
                foreach ($fieldMappings as $field => $number) {
                    $member->$field = $data[$number];
                }
                $member->save();
                $this->addCourses($member, $data);
                $this->addAuthorities($member, $data);
            }
            fclose($handle);
        }
        // second round to set up the family member relationships
        if (($handle = fopen("$fileName", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                $member = \App\Models\BackpackUser::where('member_number', $data[2])->first();
                if ($data[34] && $data[34] != $data[2]) {
                    $primary_member = \App\Models\BackpackUser::where('member_number', $data[34])->first();
                    if (!$primary_member) {
                        print_r("Unable to find primary_member $data[34] for member $data[2]\n");
                        continue;
                    }
                    print_r(" hooked up primary member $data[34]\n");
                    $member->primary()->associate($primary_member);
                    $member->save();
                }
            }
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
            46 => 20,
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
