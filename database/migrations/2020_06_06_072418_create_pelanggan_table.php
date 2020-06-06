<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelangganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->string('title');
            $table->string('nama');
            $table->string('email');
            $table->string('telepon');
            $table->string('alamat');
            $table->string('password');
            $table->integer('saldo_dompet');
            $table->dateTime('last_update');
            $table->string('fcm_token');
            $table->integer('trash');
            $table->integer('jml_transaksi');
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
        Schema::dropIfExists('pelanggan');
    }
}
