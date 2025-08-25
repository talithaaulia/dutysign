<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['spt.pegawais'])->latest()->get();
        return view('admin.viewReport', compact('reports'));
    }

    public function create()
    {
        return view('admin.inputReport');
    }

    public function store(Request $request)
{
    $request->validate([
        'spt_id'          => 'required|exists:spts,id',
        'foto_kegiatan.*' => 'required|image|mimes:jpg,jpeg,png',
        'scan_hardcopy.*' => 'required|file|mimes:pdf,jpg,jpeg,png',
        'e_toll.*'        => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        'bbm.*'           => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    ]);

    // simpan multi file ke storage
    $fotoKegiatan = [];
    if ($request->hasFile('foto_kegiatan')) {
        foreach ($request->file('foto_kegiatan') as $file) {
            $fotoKegiatan[] = $file->store('reports/foto', 'public');
        }
    }

    $scanHardcopy = [];
    if ($request->hasFile('scan_hardcopy')) {
        foreach ($request->file('scan_hardcopy') as $file) {
            $scanHardcopy[] = $file->store('reports/scan', 'public');
        }
    }

    $eToll = [];
    if ($request->hasFile('e_toll')) {
        foreach ($request->file('e_toll') as $file) {
            $eToll[] = $file->store('reports/etoll', 'public');
        }
    }

    $bbm = [];
    if ($request->hasFile('bbm')) {
        foreach ($request->file('bbm') as $file) {
            $bbm[] = $file->store('reports/bbm', 'public');
        }
    }

    Report::create([
        'spt_id'         => $request->spt_id,
        'dasar'          => $request->dasar,
        'maksud_tujuan'  => $request->maksud_tujuan,
        'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
        'nama_petugas'   => $request->nama_petugas,
        'daerah_tujuan'  => $request->daerah_tujuan,
        'hadir'          => $request->hadir,
        'petunjuk'       => $request->petunjuk,
        'masalah'        => $request->masalah,
        'saran'          => $request->saran,
        'lain_lain'      => $request->lain_lain,
        // simpan jadi string dipisahkan koma
        'foto_kegiatan'  => implode(',', $fotoKegiatan),
        'scan_hardcopy'  => implode(',', $scanHardcopy),
        'e_toll'         => implode(',', $eToll),
        'bbm'            => implode(',', $bbm),
    ]);

    return redirect()->route('report.index')->with('success', 'Laporan berhasil disimpan!');
}


    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        // Hapus dari storage
        foreach (['foto_kegiatan', 'scan_hardcopy', 'e_toll', 'bbm'] as $file) {
            if ($report->$file && Storage::disk('public')->exists($report->$file)) {
                Storage::disk('public')->delete($report->$file);
            }
        }

        // Hapus dari database
        $report->delete();

        return redirect()->route('report.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function show($id)
{
    $report = Report::with(['spt.pegawais'])->findOrFail($id);

    // Pecah string jadi array
    $report->foto_kegiatan = $report->foto_kegiatan ? explode(',', $report->foto_kegiatan) : [];
    $report->scan_hardcopy = $report->scan_hardcopy ? explode(',', $report->scan_hardcopy) : [];
    $report->e_toll = $report->e_toll ? explode(',', $report->e_toll) : [];
    $report->bbm = $report->bbm ? explode(',', $report->bbm) : [];

    return view('admin.detailReport', compact('report'));
}

    public function edit($id)
{
    $report = Report::findOrFail($id);
    return view('admin.editReport', compact('report'));
}

public function update(Request $request, $id)
{
    $report = Report::findOrFail($id);

    // validasi → semuanya opsional di update
    $request->validate([
        'foto_kegiatan.*' => 'nullable|image|mimes:jpg,jpeg,png',
        'scan_hardcopy.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        'e_toll.*'        => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        'bbm.*'           => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    ]);

    // ambil file lama
    $fotoKegiatan = $report->foto_kegiatan ? explode(',', $report->foto_kegiatan) : [];
    $scanHardcopy = $report->scan_hardcopy ? explode(',', $report->scan_hardcopy) : [];
    $eToll        = $report->e_toll ? explode(',', $report->e_toll) : [];
    $bbm          = $report->bbm ? explode(',', $report->bbm) : [];

    // kalau ada upload baru → tambahkan
    if ($request->hasFile('foto_kegiatan')) {
        foreach ($request->file('foto_kegiatan') as $file) {
            $fotoKegiatan[] = $file->store('reports/foto', 'public');
        }
    }
    if ($request->hasFile('scan_hardcopy')) {
        foreach ($request->file('scan_hardcopy') as $file) {
            $scanHardcopy[] = $file->store('reports/scan', 'public');
        }
    }
    if ($request->hasFile('e_toll')) {
        foreach ($request->file('e_toll') as $file) {
            $eToll[] = $file->store('reports/etoll', 'public');
        }
    }
    if ($request->hasFile('bbm')) {
        foreach ($request->file('bbm') as $file) {
            $bbm[] = $file->store('reports/bbm', 'public');
        }
    }

    $report->update([
        'dasar'             => $request->dasar,
        'maksud_tujuan'     => $request->maksud_tujuan,
        'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
        'nama_petugas'      => $request->nama_petugas,
        'daerah_tujuan'     => $request->daerah_tujuan,
        'hadir'             => $request->hadir,
        'petunjuk'          => $request->petunjuk,
        'masalah'           => $request->masalah,
        'saran'             => $request->saran,
        'lain_lain'         => $request->lain_lain,
        'foto_kegiatan'     => implode(',', $fotoKegiatan),
        'scan_hardcopy'     => implode(',', $scanHardcopy),
        'e_toll'            => implode(',', $eToll),
        'bbm'               => implode(',', $bbm),
    ]);

    return redirect()->route('report.index')->with('success', 'Laporan berhasil diperbarui!');
}

public function download($folder, $filename)
{
    $path = "reports/{$folder}/{$filename}";

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    return Storage::disk('public')->download($path);
}

}
