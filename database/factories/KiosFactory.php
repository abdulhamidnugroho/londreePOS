<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'nama' => $faker->company,
        'alamat' => $faker->address,
        'no_telp' => $faker->unique()->randomNumber($nbDigits = 7),
        'id_owner' => $faker->unique()->randomNumber($nbDigits = 3),
        'pesan_antar' => $faker->randomElement([1, 0]),
        'trash' => $faker->randomElement([1, 0]),
        'logo' => $faker->image(),
        'alamat_logo' => $faker->image($dir = '/tmp', $width = 640, $height = 480),
        'ketentuan' => $faker->sentence($nbWords = 6),
    ];
});
