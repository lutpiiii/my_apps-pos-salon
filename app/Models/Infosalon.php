<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infosalon extends Model
{
    protected $table = 'infosalon';
    protected $primaryKey = 'id_inf';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'judul_inf',
        'foto_inf',
        'keterangan_inf',
    ];
}
