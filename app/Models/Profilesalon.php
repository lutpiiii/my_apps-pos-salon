<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profilesalon extends Model
{
    protected $table = 'profilesalon';
    protected $primaryKey = 'id_prf';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nama_prf',
        'keterangan_prf',
        'notelp_prf',
        'email_prf',
    ];
}
