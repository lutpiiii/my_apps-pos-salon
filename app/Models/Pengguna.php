<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_p';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nama_p',
        'username_p',
        'password_p',
        'foto_p',
        'role_p',
    ];

    protected $hidden = [
        'password_p',
    ];

    protected $casts = [
        'role_p' => 'string',
    ];

    public function setPasswordPAttribute($value): void
    {
        if (empty($value)) {
            $this->attributes['password_p'] = $value;
            return;
        }

        if (is_string($value) && Str::startsWith($value, '$2')) {
            $this->attributes['password_p'] = $value;
            return;
        }

        $this->attributes['password_p'] = Hash::make($value);
    }

    public function getAuthPassword(): string
    {
        return $this->password_p;
    }

    public function transaksimasuks(): HasMany
    {
        return $this->hasMany(Transaksimasuk::class, 'id_pengguna', 'id_p');
    }
}
