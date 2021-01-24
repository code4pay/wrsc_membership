<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\App\Model\Membershiptype;
use Faker\Generator as Faker;

$factory->define(Membershiptype::class, function (Faker $faker) {
    return [
        'name' =>  'Primary',
        'description' => 'All single members are Primary Members,  for family groups, Primary is key contact point'
    ];
});
