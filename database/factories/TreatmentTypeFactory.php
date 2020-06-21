<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Treatment_type;
use Faker\Generator as Faker;

$factory->define(Treatment_type::class, function (Faker $faker) {
    return [
        'nama' => $faker->word,
    ];
});
