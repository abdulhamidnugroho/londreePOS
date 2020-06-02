<?php

use Illuminate\Database\Seeder;

class KiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Kios::class, 100)->create();
    }
}
