<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spt extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'dasar',
        'untuk',
        'tanggal',
        'ditetapkan_di',
        'status',
    ];

    public function pegawais(){
        return $this->belongsToMany(Pegawai::class, 'pegawai_spt')
            ->withPivot(['nama', 'pangkat_gol', 'nip', 'niptt_pk', 'jabatan',])
            ->withTimestamps();
    }

    public function pegawaiSpt(){
        return $this->hasMany(PegawaiSpt::class);
    }

}
