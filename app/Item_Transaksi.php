<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_Transaksi extends Model
{
    protected $fillable = [
        'transaksi_id',
        'harga_layanan_id',
        'kuantitas',
        'harga',
    ];
}
