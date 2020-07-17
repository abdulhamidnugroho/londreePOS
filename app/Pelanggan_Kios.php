<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan_Kios extends Model
{
    protected $table = 'pelanggan_kios';

    protected $fillable = ['owner_id', 'pelanggan_id'];
}
