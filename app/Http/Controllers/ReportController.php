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
            'spt_id'        => 'required|exists:spts,id',
            'foto_kegiatan' => 'required|file|mimes:jpg,jpeg,png',
            'scan_hardcopy' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'e_toll'        => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'bbm'           => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $data = [
            'spt_id'        => $request->spt_id,
            'foto_kegiatan' => $request->file('foto_kegiatan')->store('reports', 'public'),
            'scan_hardcopy' => $request->file('scan_hardcopy')->store('reports', 'public'),
        ];

        // File opsional
        if ($request->hasFile('e_toll')) {
            $data['e_toll'] = $request->file('e_toll')->store('reports', 'public');
        }
        if ($request->hasFile('bbm')) {
            $data['bbm'] = $request->file('bbm')->store('reports', 'public');
        }

        Report::create($data);

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
        return view('admin.detailReport', compact('report'));
    }

}
