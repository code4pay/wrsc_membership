<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershiptypesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('membershiptypes')->insert([
            [
                'id' =>1,
                'name' => 'Pending',
                'description' => 'Member not yet approved'
            ],
            [
                'id' =>3,
                'name' => 'Life',
                'description' => 'Awarded to long term members - now closed'
            ],
            [
                'id' =>4,
                'name' => 'Temporary',
                'description' => 'For members usually joining for a specific task and only lasts 4 months',
            ],
            [
                'id' =>5,
                'name' => 'Primary',
                'description' => 'All single members are Primary Members,  for family groups, Primary is key contact point',
            ],
            [
                'id' =>6,
                'name' => 'Family',
                'description' => 'Can only be a family member to a Primary member.'
            ],
            [
                'id' =>7,
                'name' => 'Honrary',
                'description' => 'In recognition of many years of fundraising service. Free membership for life',
            ],
            [
                'id' =>8,
                'name' => 'Inactive',
                'description' => 'Members who have resigned, not renewed or passed away. Records are kept for reference, and rejoining on occasion',
            ],
            [
                'id' =>9,
                'name' => 'Junior',
                'description' => 'For members under 18 years of age, by law cannot care for wildlife'
            ],

        ]);
    }
}
