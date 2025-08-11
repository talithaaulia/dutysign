<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function index(){
        $pegawais = Pegawai::all();
        return view('pegawai.index', compact('pegawais'));
    }

    public function create(){
        return view('pegawai.create');
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required|string',
            'pangkat_gol' => 'nullable|string',
            'status_pegawai' => 'required|in:pns,nonpns',
            'nip' => 'nullable|string',
            'niptt_pk' => 'nullable|string',
            'jabatan' => 'nullable|string',
        ]);

        Pegawai::create($request->all());

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }
}
