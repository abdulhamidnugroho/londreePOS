<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_Transaksi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_transaksi';

    protected $fillable = [
        'transaksi_id',
        'harga_layanan_id',
        'kuantitas',
        'harga',
    ];
}
