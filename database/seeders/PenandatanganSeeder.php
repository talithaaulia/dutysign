<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenandatanganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penandatangan')->insert([
            [
                'nama' => 'Yusmanu, S.S.T.',
                'jabatan' => 'Sekretaris',
                'pangkat_gol' => 'Pembina Tk. I (IV/b)',
                'nip' => '19680831 199201 1 001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dra. Restu Novi Widiani, MM',
                'jabatan' => 'Kepala',
                'pangkat_gol' => 'Pembina Utama Muda (IV/e)',
                'nip' => '19661117 199103 2 008',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
