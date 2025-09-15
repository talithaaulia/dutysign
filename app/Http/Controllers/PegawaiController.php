<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use Maatwebsite\Excel\Facades\Excel;

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
            'nip' => 'nullable|string',
            'niptt_pk' => 'nullable|string',
            'jabatan' => 'nullable|string',
        ]);

        Pegawai::create($request->all());

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit($id){
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama' => 'required|string',
            'pangkat_gol' => 'nullable|string',
            'nip' => 'nullable|string',
            'niptt_pk' => 'nullable|string',
            'jabatan' => 'nullable|string',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($request->all());

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy($id){
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $data = Excel::toArray([], $file);

        if (!empty($data[0])) {
            foreach ($data[0] as $row) {
                if (count($row) < 5) continue; // pastikan ada 5 kolom

                Pegawai::updateOrCreate(
                    ['nip' => $row[2], 'niptt_pk' => $row[3]], // supaya ga duplicate
                    [
                        'nama'        => $row[0],
                        'pangkat_gol' => $row[1],
                        'jabatan'     => $row[4],
                    ]
                );
            }
        }
        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diimport!');
    }
}
