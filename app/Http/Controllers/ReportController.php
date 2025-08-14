<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::latest()->get();
        return view('admin.viewReport', compact('reports'));
    }

    public function create()
    {
        return view('admin.inputReport');
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto_kegiatan' => 'required|file|mimes:jpg,jpeg,png',
            'scan_hardcopy' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'e_toll'        => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'bbm'           => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $data = [];

        // Simpan file wajib
        $data['foto_kegiatan'] = $request->file('foto_kegiatan')->store('reports', 'public');
        $data['scan_hardcopy'] = $request->file('scan_hardcopy')->store('reports', 'public');

        // File opsional
        if ($request->hasFile('e_toll')) {
            $data['e_toll'] = $request->file('e_toll')->store('reports', 'public');
        }
        if ($request->hasFile('bbm')) {
            $data['bbm'] = $request->file('bbm')->store('reports', 'public');
        }

        // Data tambahan
        $data['nomor_surat'] = $request->nomor_surat ?? 'Belum Ada';
        $data['tanggal_laporan'] = now()->toDateString();
        $data['nama_pelapor'] = auth()->user()->name ?? 'Admin';

        Report::create($data);

        return redirect()->route('report.index')->with('success', 'Laporan berhasil disimpan!');
    }

    public function destroy($id)
{
    $report = Report::findOrFail($id);

    // Hapus file dari storage jika ada
    if ($report->foto_kegiatan && Storage::disk('public')->exists($report->foto_kegiatan)) {
        Storage::disk('public')->delete($report->foto_kegiatan);
    }
    if ($report->scan_hardcopy && Storage::disk('public')->exists($report->scan_hardcopy)) {
        Storage::disk('public')->delete($report->scan_hardcopy);
    }
    if ($report->e_toll && Storage::disk('public')->exists($report->e_toll)) {
        Storage::disk('public')->delete($report->e_toll);
    }
    if ($report->bbm && Storage::disk('public')->exists($report->bbm)) {
        Storage::disk('public')->delete($report->bbm);
    }

    // Hapus dari database
    $report->delete();

    return redirect()->route('report.index')->with('success', 'Laporan berhasil dihapus.');
}
}
