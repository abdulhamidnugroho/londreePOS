<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pelanggan');
            $table->string('user_latlong');
            $table->integer('status_order');
            $table->double('id_transaksi');
            $table->integer('id_kios');
            $table->string('jarak');
            $table->string('time_millis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbox');
    }
}
