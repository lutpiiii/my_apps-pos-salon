<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksikeluar extends Model
{
    protected $table = 'transaksikeluar';
    protected $primaryKey = 'id_tk';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'judul_k',
        'keterangan_k',
        'harga_k',
        'tanggal_k',
    ];

    protected $casts = [
        'harga_k' => 'decimal:2',
        'tanggal_k' => 'date',
    ];
}
