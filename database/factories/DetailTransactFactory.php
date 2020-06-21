<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Detail_Transact;
use App\Transact;
use App\Treatment_Price;
use App\Treatment_type;
use Faker\Generator as Faker;

$factory->define(Detail_Transact::class, function (Faker $faker) {
    return [
        'transact_id' => function () {
            return Transact::all()->random();
        },
        'treatment_price_id' => function () {
            return Treatment_Price::all()->random();
        },
        'treatment_type_id' => function () {
            return Treatment_type::all()->random();
        },
        'qty' => $faker->numberBetween(0, 100),
        'price' => $faker->numberBetween(0, 1000000),
        'total' => $faker->numberBetween(0, 1000000),
    ];
});
