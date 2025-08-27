<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Spt;
use Barryvdh\DomPDF\Facade\Pdf;
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

        $pangkatList = Pegawai::pluck('pangkat_gol')->unique();
        $jabatanList = Pegawai::pluck('jabatan')->unique();

        return view('admin.create', compact('pegawais', 'jabatanList', 'pangkatList'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nomor_surat' => 'required|string',
            'dasar' => 'required|array',
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


    public function edit($id){
        $spt = Spt::with('pegawais')->findOrFail($id);
        $pegawais = Pegawai::all();

        $pangkatList = Pegawai::select('pangkat_gol')->distinct()->pluck('pangkat_gol');
        $jabatanList = Pegawai::select('jabatan')->distinct()->pluck('jabatan');

        return view('admin.editSpt', compact('spt', 'pegawais', 'jabatanList', 'pangkatList'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'nomor_surat' => 'required',
            'dasar' => 'required|array',
            'untuk' => 'required|string',
            'kepada' => 'required|array',
            'kepada.*.pegawai_id' => 'required|exists:pegawais,id',
            'kepada.*.pangkat_gol' => 'required|string',
            'kepada.*.nip' => 'nullable|string',
            'kepada.*.jabatan' => 'required|string',
            'ditetapkan_di' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $spt = Spt::findOrFail($id);
        $spt->update([
            'nomor_surat' => $request->nomor_surat,
            'dasar' => implode("\n", $request->dasar),
            'untuk' => $request->untuk,
            'ditetapkan_di' => $request->ditetapkan_di,
            'tanggal' => $request->tanggal,
        ]);

        $spt->pegawais()->detach();
        foreach($request->kepada as $kepada){
            $spt->pegawais()->attach($kepada['pegawai_id'], [
                'nama'       => Pegawai::find($kepada['pegawai_id'])->nama,
                'pangkat_gol' => $kepada['pangkat_gol'],
                'nip' => $kepada['nip'] ?? null,
                'niptt_pk' => $kepada['niptt_pk'] ?? null,
                'jabatan' => $kepada['jabatan'],
            ]);
        }

        return redirect()->route('spt.index')->with('success', 'SPT berhasil diperbarui.');
    }

    public function destroy($id){
        Spt::findOrFail($id)->delete();
        alert()->success('Berhasil', 'Data SPT berhasil dihapus');
        return redirect()->back();
    }

    // upload feature
    public function uploadForm(){
        $spts = Spt::orderBy('created_at', 'desc')->get();
        return view('admin.upload', compact('spts'));
    }

    public function uploadSurat(Request $request){
        $request->validate([
            'spt_id' => 'required|exists:spts,id',
            'file_scan' => 'required|mimes:pdf,jpg,jpeg,png|max:1024', // max 1MB
        ]);

        $spt = Spt::findOrFail($request->spt_id);

        // Simpan file di storage/app/public/surat_scan
        $path = $request->file('file_scan')->store('surat_scan', 'public');

        $spt->update([
            'file_scan' => $path,
            'status' => 'disetujui'
        ]);

        return redirect()->route('spt.index')->with('success', 'Surat scan berhasil diupload');
    }

    public function download($id) {
        $spt = Spt::findOrFail($id);

        if (!$spt->file_scan || !Storage::disk('public')->exists($spt->file_scan)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        // buat extension filenya
        $extension = pathinfo($spt->file_scan, PATHINFO_EXTENSION);

        //  biar nama filenya sama
        $filename = 'SPT-No. ' . str_replace('/', '_', $spt->nomor_surat) . '.' . $extension;

        $path = Storage::disk('public')->path($spt->file_scan);
        return response()->download($path, $filename);

    }

    public function downloadAll()
{
    $spts = Spt::with('pegawais')->get();

    $pdf = Pdf::loadView('admin.pdf_all', compact('spts'))
          ->setPaper('a4', 'landscape');


    return $pdf->download('daftar_spt.pdf');
}


}
