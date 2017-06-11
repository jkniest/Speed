<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Models\Server::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->userName,
        'token' => str_random()
    ];
});

$factory->define(\App\Models\Test::class, function () {
    return [
        'server_id'  => factory(\App\Models\Server::class)->lazy(),
        'down_speed' => mt_rand(1000, 1000000),
        'up_speed'   => mt_rand(500, 500000),
        'created_at' => \Carbon\Carbon::createFromTime(mt_rand(0, 23))
    ];
});
