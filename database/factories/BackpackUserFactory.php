<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BackpackUser;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(BackpackUser::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' =>$faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'address' => $faker->streetAddress, 
        'city' => $faker->randomElement(array('Nowra', 'kiama', 'Vincentia', 'Milton')),
        'state' =>'NSW',
        'country' =>'Australia',
        'post_code' => 2540,
        'address_residential' => $faker->streetAddress, 
        'city_residential' => $faker->randomElement($array = array('Nowra', 'kiama', 'Vincentia', 'Milton')),
        'state_residential' =>'NSW',
        'country_residential' =>'Australia',
        'post_code_residential' => 2540,
        'member_number' => $faker->numberBetween($min = 1000, $max = 9000),
        'region_id' => '1',
        'mobile' => $faker->e164PhoneNumber,
        'home_phone' => '33317656',
        'joined' => '2020-01-01',
        'member_type_id' => DB::table('membershiptypes')->where('name','Primary')->value('id')


    ];        
});
