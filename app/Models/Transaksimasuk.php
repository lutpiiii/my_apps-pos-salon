<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksimasuk extends Model
{
    protected $table = 'transaksimasuk';
    protected $primaryKey = 'id_t';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'id_reservasi',
        'tanggal_t',
        'totalBayar_t',
        'bayar_t',
        'kembali_t',
    ];

    protected $casts = [
        'tanggal_t' => 'datetime',
        'totalBayar_t' => 'decimal:2',
        'bayar_t' => 'decimal:2',
        'kembali_t' => 'decimal:2',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_p');
    }

    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id_r');
    }

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(Detailtransaksi::class, 'id_masuk', 'id_t');
    }

    public function getKodeTAttribute()
    {
        if ($this->id_reservasi && $this->reservasi) {
            return $this->reservasi->kode_reservasi;
        }

        $tanggal = $this->tanggal_t ?? now();
        return 'TRX-' . $tanggal->format('Ymd') . '-' . str_pad($this->id_t, 4, '0', STR_PAD_LEFT);
    }
}
