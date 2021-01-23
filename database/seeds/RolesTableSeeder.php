<?php


use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => '2020-05-02 02:15:20',
                'updated_at' => '2020-05-02 02:15:20',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Facebook Page Admin',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 03:48:30',
                'updated_at' => '2020-07-11 03:48:30',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Phone Coordinator',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 04:00:08',
                'updated_at' => '2020-07-11 04:00:08',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'President',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 04:12:59',
                'updated_at' => '2020-07-11 04:12:59',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Secretary',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 04:13:15',
                'updated_at' => '2020-07-11 04:13:15',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Treasurer',
                'guard_name' => 'web',
                'created_at' => '2020-07-11 04:13:32',
                'updated_at' => '2020-07-11 04:13:32',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Far South Coast Coordinator',
                'guard_name' => 'web',
                'created_at' => '2020-07-14 23:58:55',
                'updated_at' => '2020-07-14 23:58:55',
            ),
        ));
        
        
    }
}