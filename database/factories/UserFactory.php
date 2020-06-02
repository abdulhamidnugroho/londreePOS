<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'telp' => $faker->unique()->randomNumber($nbDigits = 12),
        'alamat' => $faker->address,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'type' => $faker->randomElement(['admin', 'operator']),
        'id_owner' => $faker->unique()->randomNumber($nbDigits = 3),
        'activation_code' => $faker->unique()->randomNumber($nbDigits = 6),
        'trash' => $faker->randomElement([1, 0]),
        'paket_akun_id' => $faker->randomElement(['free', 'biasa', 'spesial', 'logo', 'istimewa']),
        'jml_transaksi' => $faker->unique()->randomNumber($nbDigits = 3),
        'jml_kios' => $faker->randomDigit,
        'pesan_antar' => $faker->randomElement([1, 0]),
        'saldo' => $faker->randomElement([$faker->randomNumber($nbDigits = 5), 0]),
        'referral' => $faker->word,
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
    ];
});
