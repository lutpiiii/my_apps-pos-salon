<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detailtransaksi extends Model
{
    protected $table = 'detailtransaksi';
    protected $primaryKey = 'id_detail';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_masuk',
        'id_menu',
        'harga_saat_ini',
    ];

    protected $casts = [
        'harga_saat_ini' => 'decimal:2',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksimasuk::class, 'id_masuk', 'id_t');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menulayanan::class, 'id_menu', 'id_m');
    }
}
