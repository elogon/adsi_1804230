<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'fullname'          => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'phone'             => $faker->numberBetween($min = 3100000000,
                                                     $max = 3200000000),
        'birthdate'         => $faker->date,
        'gender'            => $faker->randomElement(
                                $array = array ('Female', 'Male')),
        'address'           => $faker->address,
        'email_verified_at' => now(),
        'password'          => bcrypt('12345'),
        'remember_token' => Str::random(10),
    ];
});
