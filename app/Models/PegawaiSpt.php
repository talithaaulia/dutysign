<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiSpt extends Model
{
    protected $table = 'pegawai_spt';

    protected $fillable = [
        'spt_id',
        'pegawai_id',
        'nama',
        'pangkat_gol',
        'nip',
        'niptt_pk',
        'jabatan',
    ];

    public function spt(){
        return $this->belongsTo(Spt::class);
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }
}
