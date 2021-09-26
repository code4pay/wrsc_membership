<?php


namespace Database\Seeders;
use Illuminate\Database\Seeder;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_has_permissions')->delete();
        
        \DB::table('role_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 4,
                'role_id' => 1,
            ),
            1 => 
            array (
                'permission_id' => 7,
                'role_id' => 1,
            ),
            2 => 
            array (
                'permission_id' => 9,
                'role_id' => 1,
            ),
            3 => 
            array (
                'permission_id' => 11,
                'role_id' => 1,
            ),
            4 => 
            array (
                'permission_id' => 12,
                'role_id' => 1,
            ),
            5 => 
            array (
                'permission_id' => 13,
                'role_id' => 1,
            ),
            6 => 
            array (
                'permission_id' => 14,
                'role_id' => 1,
            ),
            7 => 
            array (
                'permission_id' => 15,
                'role_id' => 1,
            ),
            8 => 
            array (
                'permission_id' => 16,
                'role_id' => 1,
            ),
            9 => 
            array (
                'permission_id' => 17,
                'role_id' => 1,
            ),
            10 => 
            array (
                'permission_id' => 18,
                'role_id' => 1,
            ),
            11 => 
            array (
                'permission_id' => 19,
                'role_id' => 1,
            ),
            12 => 
            array (
                'permission_id' => 20,
                'role_id' => 1,
            ),
            13 => 
            array (
                'permission_id' => 21,
                'role_id' => 1,
            ),
            14 => 
            array (
                'permission_id' => 14,
                'role_id' => 2,
            ),
            15 => 
            array (
                'permission_id' => 15,
                'role_id' => 2,
            ),
            16 => 
            array (
                'permission_id' => 14,
                'role_id' => 3,
            ),
            17 => 
            array (
                'permission_id' => 15,
                'role_id' => 3,
            ),
            18 => 
            array (
                'permission_id' => 16,
                'role_id' => 3,
            ),
            19 => 
            array (
                'permission_id' => 17,
                'role_id' => 3,
            ),
            20 => 
            array (
                'permission_id' => 20,
                'role_id' => 4,
            ),
            21 => 
            array (
                'permission_id' => 20,
                'role_id' => 5,
            ),
            22 => 
            array (
                'permission_id' => 20,
                'role_id' => 6,
            ),
            23 => 
            array (
                'permission_id' => 20,
                'role_id' => 7,
            ),
        ));
        
        
    }
}