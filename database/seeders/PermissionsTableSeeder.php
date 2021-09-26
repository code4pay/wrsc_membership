<?php


namespace Database\Seeders;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 4,
                'name' => 'Modify All',
                'guard_name' => 'web',
                'created_at' => '2020-05-02 02:16:40',
                'updated_at' => '2020-07-11 04:25:24',
            ),
            1 => 
            array (
                'id' => 7,
                'name' => 'Manage Membership Types',
                'guard_name' => 'web',
                'created_at' => '2020-05-02 03:42:12',
                'updated_at' => '2020-06-19 09:53:29',
            ),
            2 => 
            array (
                'id' => 9,
                'name' => 'Manage Authorities',
                'guard_name' => 'web',
                'created_at' => '2020-06-19 09:54:04',
                'updated_at' => '2020-06-19 09:54:04',
            ),
            3 => 
            array (
                'id' => 11,
                'name' => 'Send Renewals',
                'guard_name' => 'web',
                'created_at' => '2020-06-19 11:27:13',
                'updated_at' => '2020-06-19 11:27:13',
            ),
            4 => 
            array (
                'id' => 12,
                'name' => 'Print Membership Cards',
                'guard_name' => 'web',
                'created_at' => '2020-06-19 11:28:01',
                'updated_at' => '2020-06-19 11:28:40',
            ),
            5 => 
            array (
                'id' => 13,
                'name' => 'Add Members',
                'guard_name' => 'web',
                'created_at' => '2020-07-07 08:04:51',
                'updated_at' => '2020-07-07 08:04:51',
            ),
            6 => 
            array (
                'id' => 14,
                'name' => 'Read Names',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 01:11:26',
                'updated_at' => '2020-07-11 01:11:26',
            ),
            7 => 
            array (
                'id' => 15,
                'name' => 'Read Email Address',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 01:11:47',
                'updated_at' => '2020-07-11 01:11:47',
            ),
            8 => 
            array (
                'id' => 16,
                'name' => 'Read Phone Numbers',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 01:12:02',
                'updated_at' => '2020-07-11 01:12:02',
            ),
            9 => 
            array (
                'id' => 17,
                'name' => 'Read Authorities',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 01:12:14',
                'updated_at' => '2020-07-11 01:12:14',
            ),
            10 => 
            array (
                'id' => 18,
                'name' => 'Upload Documents',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 01:12:26',
                'updated_at' => '2020-07-11 01:12:26',
            ),
            11 => 
            array (
                'id' => 19,
                'name' => 'Add Courses',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 01:13:03',
                'updated_at' => '2020-07-11 01:13:03',
            ),
            12 => 
            array (
                'id' => 20,
                'name' => 'Read All',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 01:16:56',
                'updated_at' => '2020-07-11 01:16:56',
            ),
            13 => 
            array (
                'id' => 21,
                'name' => 'View Documents',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 06:47:54',
                'updated_at' => '2020-07-11 06:47:54',
            ),
        ));
        
        
    }
}