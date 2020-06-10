<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'no_telp',
        'latitude',
        'pesan_antar',
        'trash',
        'provinsi',
        'logo',
        'alamat_logo'
    ];
}
