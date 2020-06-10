<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'admin_id',
        'jml_transaksi',
        'nama'
    ];
}
