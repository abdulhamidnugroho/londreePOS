<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelanggan';

    protected $fillable = [
        'admin_id',
        'nama',
        'alamat',
        'email',
        'telepon',
        'jml_transaksi',
        'password',
        'saldo_dompet'
    ];
}
