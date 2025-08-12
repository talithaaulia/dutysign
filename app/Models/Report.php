<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'nomor_surat',
        'tanggal_laporan',
        'nama_pelapor',
        'foto_kegiatan',
        'scan_hardcopy',
        'e_toll',
        'bbm',
    ];
}
