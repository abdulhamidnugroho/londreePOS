<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Operator_Kios;
use Faker\Generator as Faker;

$factory->define(Operator_Kios::class, function (Faker $faker) {
    return [
        'admin_id' => $faker->numberBetween($min = 50, $max = 100),
        'kios_id' => $faker->numberBetween($min = 50, $max = 80)
    ];
});
