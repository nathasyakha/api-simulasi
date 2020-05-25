<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Invoice;
use App\Treatment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::all()->random();
        },
        'treatment_id' => function () {
            return Treatment::all()->random();
        },
        'waktu_masuk' => $faker->dateTime($max = 'now', $timezone = null),
        'total' => $faker->numberBetween(0, 1000000),
        'status' => $faker->word,
    ];
});
