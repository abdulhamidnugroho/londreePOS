<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->integer('kios_id');
            $table->integer('pelanggan_id');
            $table->integer('pengerjaan_nota_id')->nullable();
            $table->string('pengerjaan_nota_nama')->nullable();
            $table->dateTime('tgl_transaksi');
            $table->dateTime('tgl_masuk_uang');
            $table->dateTime('tgl_diambil');
            $table->integer('total_harga');
            $table->integer('dp');
            $table->enum('jenis_pembayaran', ['TUNAI', 'DOMPET']);
            $table->enum('status', ['LUNAS', 'PIUTANG']);
            $table->string('status_kerja')->default(1);
            $table->integer('status_order');
            $table->enum('status_pesanan', ['online', 'offline']);
            $table->string('estimasi_waktu');
            $table->float('diskon');
            $table->integer('bayar');
            $table->integer('trash')->default(0);
            $table->text('note');
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
        Schema::dropIfExists('transaksi');
    }
}
