<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spt;
use App\Models\Pegawai;
use App\Models\PegawaiSpt;


class SptController extends Controller
{
    public function index(){
        $spts = Spt::with('pegawais')->latest()->get();
        return view('admin.list', compact('spts'));
    }

    public function create(){
        $pegawais = Pegawai::all();
        return view('admin.create', compact('pegawais'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nomor_surat' => 'required|string',
            'dasar' => 'required',
            'untuk' => 'required|string',
            'tanggal' => 'required|date',
            'kepada' => 'required|array',
            'kepada.*.pegawai_id' => 'required|exists:pegawais,id',
            'kepada.*.pangkat_gol' => 'required|string',
            'kepada.*.nip' => 'nullable|string',
            'kepada.*.jabatan' => 'required|string',
            'ditetapkan_di' => 'required|string',
        ]);

        $dasarText = is_array($validated['dasar'])
            ? implode("\n", $validated['dasar'])
            : $validated['dasar'];

        $spt = Spt::create([
            'nomor_surat' => $validated['nomor_surat'],
            'dasar' => $dasarText,
            'untuk' => $validated['untuk'],
            'tanggal' => $validated['tanggal'],
            'ditetapkan_di' => $validated['ditetapkan_di'],
        ]);

        foreach ($validated['kepada'] as $kepadaData) {
            $pegawai = Pegawai::findOrFail($kepadaData['pegawai_id']);

            PegawaiSpt::create([
                'spt_id' => $spt->id,
                'pegawai_id' => $pegawai->id,
                'nama' => $pegawai->nama,
                'pangkat_gol' => $kepadaData['pangkat_gol'],
                'nip' => $pegawai->status_pegawai === 'pns' ? $pegawai->nip : null,
                'niptt_pk' => $pegawai->status_pegawai === 'nonpns' ? $pegawai->niptt_pk : null,
                'jabatan' => $kepadaData['jabatan'],
            ]);
        }

        return redirect()->route('spt.index')->with('success', 'Surat berhasil dibuat');

    }

    public function show($id){
        $spt = Spt::with('pegawais')->findOrFail($id);
        return view('admin.detailSpt', compact('spt'));
    }


    public function edit($id)
{
    $spt = Spt::with('pegawais')->findOrFail($id);
    return view('admin.editSpt', compact('spt'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nomor_surat' => 'required',
        'tanggal' => 'required|date',
        'status' => 'required|in:menunggu,disetujui,ditolak',
    ]);

    $spt = Spt::findOrFail($id);
    $spt->update([
        'nomor_surat' => $request->nomor_surat,
        'tanggal' => $request->tanggal,
        'status' => $request->status,
    ]);

    return redirect()->route('spt.index')->with('success', 'SPT berhasil diperbarui.');
}

    public function destroy($id)
{
    Spt::findOrFail($id)->delete();
    alert()->success('Berhasil', 'Data SPT berhasil dihapus');
    return redirect()->back();
}



}
