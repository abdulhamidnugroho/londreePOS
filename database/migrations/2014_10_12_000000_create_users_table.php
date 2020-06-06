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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('telp')->unique()->nullable();
            $table->string('alamat', 100)->nullable();
            $table->string('password');
            $table->string('type');
            $table->integer('id_owner')->nullable();
            $table->text('activation_code')->nullable();
            $table->string('fcm_token', 255)->nullable();
            $table->integer('trash');
            $table->string('paket_akun_id')->nullable();
            $table->integer('jml_transaksi')->nullable();
            $table->integer('jml_kios')->nullable();
            $table->integer('pesan_antar')->nullable();
            $table->integer('saldo')->nullable();
            $table->string('reveral')->nullable();
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
