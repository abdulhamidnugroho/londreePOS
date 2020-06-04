<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\OperatorKios;
use Faker\Generator as Faker;

$factory->define(OperatorKios::class, function (Faker $faker) {
    return [
        'admin_id' => $faker->numberBetween($min = 30, $max = 100),
        'kios_id' => $faker->numberBetween($min = 30, $max = 80)
    ];
});
