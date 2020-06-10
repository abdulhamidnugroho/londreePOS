<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Kios;
use App\Model;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Kios::class, function (Faker $faker) {
    return [
        'nama' => $faker->company,
        'alamat' => $faker->address,
        'no_telp' => $faker->unique()->randomNumber($nbDigits = 3),
        'id_owner' => $faker->numberBetween($min = 50, $max = 100),
        'pesan_antar' => $faker->randomElement([1, 0]),
        'trash' => $faker->randomElement([1, 0]),
        'logo' => $faker->image(),
        'alamat_logo' => Str::random(6),
        'ketentuan' => $faker->sentence($nbWords = 6),
    ];
});
