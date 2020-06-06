<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiKiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_kios', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kios');
            $table->integer('transaksi_harian');
            $table->integer('transaksi_bulanan');
            $table->integer('transaksi_tahunan');
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
        Schema::dropIfExists('transaksi_kios');
    }
}
