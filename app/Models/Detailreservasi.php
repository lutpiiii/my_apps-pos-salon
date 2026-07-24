<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detailreservasi extends Model
{
    protected $table = 'detailreservasi';
    protected $primaryKey = 'id_dr';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_reservasi',
        'id_menu',
        'harga_saat_ini',
        'jumlah',
    ];

    protected $casts = [
        'harga_saat_ini' => 'decimal:2',
        'jumlah' => 'integer',
    ];

    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id_r');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menulayanan::class, 'id_menu', 'id_m');
    }

    public function getSubtotalAttribute()
    {
        return $this->harga_saat_ini * $this->jumlah;
    }
}
