<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategorilayanan extends Model
{
    protected $table = 'kategorilayanan';
    protected $primaryKey = 'id_k';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nama_k',
        'is_deleted',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    public function menulayanans(): HasMany
    {
        return $this->hasMany(Menulayanan::class, 'id_kategori', 'id_k');
    }
}
