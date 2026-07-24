<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    protected $primaryKey = 'id_r';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'kode_reservasi',
        'nama_pelanggan',
        'notelp_pelanggan',
        'email_pelanggan',
        'id_menu',
        'id_stylist',
        'tanggal_reservasi',
        'jam_reservasi',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_reservasi' => 'date',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menulayanan::class, 'id_menu', 'id_m');
    }

    public function details(): HasMany
    {
        return $this->hasMany(Detailreservasi::class, 'id_reservasi', 'id_r');
    }

    public function stylist(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_stylist', 'id_p');
    }

    public function getTotalHargaAttribute()
    {
        if ($this->details && $this->details->count() > 0) {
            return $this->details->sum(function ($d) {
                return $d->harga_saat_ini * $d->jumlah;
            });
        }
        return $this->menu ? $this->menu->harga_m : 0;
    }

    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'Menunggu':
                return '<span class="badge bg-warning text-dark"><i class="bi bi-clock-history me-1"></i>Menunggu</span>';
            case 'Disetujui':
                return '<span class="badge bg-info text-white"><i class="bi bi-check-circle me-1"></i>Disetujui</span>';
            case 'Selesai':
                return '<span class="badge bg-success"><i class="bi bi-check2-all me-1"></i>Selesai</span>';
            case 'Dibatalkan':
                return '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Dibatalkan</span>';
            default:
                return '<span class="badge bg-secondary">' . $this->status . '</span>';
        }
    }
}
