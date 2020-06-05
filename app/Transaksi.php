<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'owner_id',
        'kios_id',
        'pelanggan_id',
        'pengerjaan_nota_id',
        'pengerjaan_nota_nama',
        'tgl_transaksi',
        'tgl_masuk_uang',
        'tgl_diambil',
        'total_harga',
        'dp',
        'jenis_pembayaran',
        'status',
        'status_kerja',
        'status_order',
        'status_pesanan',
        'estimasi_waktu',
        'diskon',
        'bayar',
        'trash',
        'note',
        'jml_transaksi',
    ];
}
