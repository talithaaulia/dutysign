<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spt;
use App\Models\Pegawai;

class DashboardController extends Controller
{
    public function index(Request $request){
        $countDisetujui   = Spt::where('status', 'disetujui')->count();
        $countMenunggu = Spt::where('status', 'menunggu')->count();
        $countSudahTTD = Spt::whereNotNull('file_scan')->count();

        $search = $request->input('search', '');

        // List pegawai + jumlah perjalanan, jd pake relasi 'spts'
        $query = Pegawai::query()->withCount('spts');

        if ($search !== '') {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $pegawais = $query->orderBy('nama')->get();

        return view(
            'dashboard', compact('pegawais', 'search', 'countMenunggu', 'countSudahTTD', 'countDisetujui')
        );
    }

    public function detail($id) {
        $pegawai = Pegawai::with('sptLangsung')->findOrFail($id);
        return view('pegawai.detail', compact('pegawai'));
    }
}
