<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kios', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            $table->string('no_telp');
            $table->integer('id_owner');
            $table->text('latitude')->nullable();
            $table->integer('pesan_antar');
            $table->integer('trash');
            $table->string('provinsi')->nullable();
            $table->text('logo')->nullable();
            $table->text('alamat_logo')->nullable();
            $table->text('ketentuan')->nullable();
            $table->text('estimasi')->nullable();
            $table->text('pesan_wa_sms')->nullable();
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
        Schema::dropIfExists('kios');
    }
}
