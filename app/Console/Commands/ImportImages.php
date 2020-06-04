<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ImportImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wrsc:import_images
    {--F|file_name= : the name of the tab delimited file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import images';

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
                if (Storage::disk('private')->exists('profile_images/' . $data[2].'.jpg' )){
                    $member->image = 'profile_images/'.$data[2].'.jpg';
                    $member->save;
                }
            }
            fclose($handle);
        }
    }

}