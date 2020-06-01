<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('telp');
            $table->string('alamat', 100);
            $table->string('password');
            $table->string('type');
            $table->integer('id_owner');
            $table->text('activation_code');
            $table->string('fcm_token', 255);
            $table->integer('trash');
            $table->string('paket_akun_id');
            $table->integer('jml_transaksi');
            $table->integer('jml_kios');
            $table->integer('pesan_antar');
            $table->integer('saldo');
            $table->string('referral');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
