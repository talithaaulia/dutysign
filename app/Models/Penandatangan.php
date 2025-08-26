<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

    class Penandatangan extends Model
{
    protected $table = 'penandatangan';
    protected $fillable = ['nama', 'jabatan', 'pangkat_gol', 'nip'];

    public function spts()
{
    return $this->hasMany(Spt::class, 'penandatangan_id');
}

}




