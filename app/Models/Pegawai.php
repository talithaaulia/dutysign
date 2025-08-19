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

    public function spts(){
        return $this->hasMany(\App\Models\PegawaiSpt::class);
    }

    public function sptLangsung(){
        return $this->belongsToMany(Spt::class, 'pegawai_spt')
            ->withPivot(['nama', 'pangkat_gol', 'nip', 'niptt_pk', 'jabatan'])
            ->withTimestamps();
    }
}
