<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->randomElement(array('Nowra', 'kiama', 'Vincentia', 'Milton')),
            'state' => 'NSW',
            'country' => 'Australia',
            'post_code' => 2540,
            'address_residential' => $this->faker->streetAddress,
            'city_residential' => $this->faker->randomElement($array = array('Nowra', 'kiama', 'Vincentia', 'Milton')),
            'state_residential' => 'NSW',
            'country_residential' => 'Australia',
            'post_code_residential' => 2540,
            'member_number' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'region_id' => '1',
            'mobile' => $this->faker->e164PhoneNumber,
            'home_phone' => '33317656',
            'joined' => '2020-01-01',
            'member_type_id' => DB::table('membershiptypes')->where('name', 'Primary')->value('id')


        ];
    }
}
