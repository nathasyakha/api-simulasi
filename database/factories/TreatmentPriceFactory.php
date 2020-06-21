<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Treatment_Price;
use App\Treatment_type;
use App\User;
use Faker\Generator as Faker;

$factory->define(Treatment_Price::class, function (Faker $faker) {
    return [
        'treatment_type_id' => function () {
            return Treatment_type::all()->random();
        },
        'harga' => $faker->numberBetween(0, 1000000),
        'user_id' => function () {
            return User::all()->random();
        },
    ];
});
