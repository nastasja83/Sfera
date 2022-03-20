<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Position;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

    $position = Position::inRandomOrder()->first();
    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'middle_name' => $faker->firstName,
        'position_id' => $position->id,
        'email' => $faker->unique()->safeEmail,
        'is_admin' => false,
        'phone' => $faker->unique()->regexify('/^(\+79)[0-9]{9}$/'),
        'email_verified_at' => now(),
        'password' => bcrypt(Str::random(10)),
        'remember_token' => Str::random(10),
    ];
});
