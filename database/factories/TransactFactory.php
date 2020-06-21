<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transact;
use App\User;
use Faker\Generator as Faker;

$factory->define(Transact::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::all()->random();
        },
        'amount' => $faker->numberBetween(0, 1000000),
        'start_date' => $faker->dateTime($max = 'now', $timezone = null),
        'end_date' => $faker->dateTime($max = 'now', $timezone = null),
        'status' => $faker->boolean(33),
    ];
});
