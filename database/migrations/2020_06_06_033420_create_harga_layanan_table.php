<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_layanan', function (Blueprint $table) {
            $table->id();
            $table->integer('layanan_id');
            $table->string('jenis_layanan');
            $table->integer('kios_id');
            $table->string('harga');
            $table->string('last_update');
            $table->integer('trash');
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
        Schema::dropIfExists('harga_layanan');
    }
}
