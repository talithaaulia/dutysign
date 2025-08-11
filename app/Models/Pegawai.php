<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'nama',
        'pangkat_gol',
        'status_pegawai',
        'nip',
        'niptt_pk',
        'jabatan',
    ];

}
