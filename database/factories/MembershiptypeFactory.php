<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Membershiptype as ModelsMembershiptype;


class MembershiptypeFactory extends Factory
{

    protected $model = ModelsMembershiptype::class;
    public function definition()
    {
        return [
            'name' =>  'Primary',
            'description' => 'All single members are Primary Members,  for family groups, Primary is key contact point'
        ];
    }
}
