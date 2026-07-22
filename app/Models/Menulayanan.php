<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menulayanan extends Model
{
    protected $table = 'menulayanan';
    protected $primaryKey = 'id_m';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'nama_m',
        'harga_m',
        'is_deleted',
    ];

    protected $casts = [
        'harga_m' => 'decimal:2',
        'is_deleted' => 'boolean',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategorilayanan::class, 'id_kategori', 'id_k');
    }

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(Detailtransaksi::class, 'id_menu', 'id_m');
    }
}
