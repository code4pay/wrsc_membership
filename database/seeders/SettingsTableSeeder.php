<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
          \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 4,
                'name' => 'current_paid_to',
                'value' => '2022-06-02',
                'comment' => 'sets the Current Membership Year End',
                'created_at' => '2020-05-02 02:16:40',
                'updated_at' => '2020-07-11 04:25:24',
            ),
        ));       
        
        
    }
}