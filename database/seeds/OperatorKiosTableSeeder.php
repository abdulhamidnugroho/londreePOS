<?php

use Illuminate\Database\Seeder;

class OperatorKiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\OperatorKios::class, 100)->create();
    }
}
