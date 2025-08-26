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
        'file_scan',
        'penandatangan',
    ];

    public function pegawais(){
        return $this->belongsToMany(Pegawai::class, 'pegawai_spt')
            ->withPivot(['nama', 'pangkat_gol', 'nip', 'niptt_pk', 'jabatan',])
            ->withTimestamps();
    }

    public function pegawaiSpt(){
        return $this->hasMany(PegawaiSpt::class);
    }

    // public function getSigner(){

    //     $signers = [
    //         'kepala' => [
    //             'jabatan' => 'Kepala',
    //             'nama'    => 'Dra. Restu Novi Widiani, MM',
    //             'pangkat' => 'Pembina Utama Muda',
    //             'nip'     => '196611171991032008',
    //         ],
    //         'sekretaris' => [
    //             'jabatan' => 'Sekretaris',
    //             'nama'    => 'Yusmanu, S.S.T.',
    //             'pangkat' => 'Pembina Tingkat I/(IV/b)',
    //             'nip'     => '196808311992011001',
    //         ],
    //     ];

    //     return $this->penandatangan ? $signers[$this->penandatangan] : null;
    // }

    public function penandatangan()
{
    return $this->belongsTo(Penandatangan::class, 'penandatangan_id');
}
}
