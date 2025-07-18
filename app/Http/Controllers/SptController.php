<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SptController extends Controller
{
    public function store(Request $request)
{
    // Validasi data
    $validated = $request->validate([
        'nomor_surat' => 'required|string',
        'dasar' => 'required|string',
        'untuk' => 'required|string',
        'tanggal' => 'required|date',
        'kepada' => 'required|array',
        'kepada.*.nama' => 'required|string',
        'kepada.*.nip' => 'required|string',
        'kepada.*.jabatan' => 'required|string',
        'kepada.*.golongan' => 'required|string',
    ]);
    // Simpan data ke database
    return redirect()->route('dashboard')->with('success', 'Surat Tugas berhasil disimpan.');
}

}
