<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'spt_id',          // 🔑 tambahkan foreign key
        'nomor_surat',
        'tanggal_laporan',
        'nama_pelapor',
        'dasar',
        'maksud_tujuan',
        'waktu_pelaksanaan',
        'nama_petugas',
        'daerah_tujuan',
        'hadir',
        'petunjuk',
        'masalah',
        'saran',
        'lain_lain',
        'foto_kegiatan',
        'scan_hardcopy',
        'e_toll',
        'bbm',
    ];

    public function spt()
    {
        return $this->belongsTo(Spt::class);
    }
}
