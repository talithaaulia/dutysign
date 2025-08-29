<?php

namespace App\Http\Controllers;

use App\Models\Penandatangan;
use Illuminate\Http\Request;

class PenandatanganController extends Controller
{
    public function index(){
        $penandatangans = Penandatangan::latest()->get();
        return view('penandatangan.index', compact('penandatangans'));
    }

    public function create(){
        return view('penandatangan.create');
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:Kepala,Sekretaris',
            'pangkat_gol' => 'required|string|max:100',
            'nip' => 'required|string|max:50|unique:penandatangan,nip',
        ]);

        Penandatangan::create($request->only('nama', 'jabatan', 'pangkat_gol', 'nip'));

        return redirect()->route('penandatangan.index')->with('success', 'Penandatangan berhasil ditambahkan.');
    }

    public function destroy($id){
        $penandatangan = Penandatangan::findOrFail($id);
        $penandatangan->delete();

        return redirect()->route('penandatangan.index')->with('success', 'Penandatangan berhasil dihapus.');
    }
}
