<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'spt_id',          // 🔑 tambahkan foreign key
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
