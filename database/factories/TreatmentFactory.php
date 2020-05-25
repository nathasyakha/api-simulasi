<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Treatment;
use Faker\Generator as Faker;

$factory->define(Treatment::class, function (Faker $faker) {
    return [
        'jenis_treatment' => $faker->word,
        'harga' => $faker->numberBetween(0, 1000000),
        'waktu_pengerjaan' => $faker->numberBetween(0, 10),
        'qty' => $faker->numberBetween(0, 10),
        'subtotal' => $faker->numberBetween(0, 1000000),
    ];
});
