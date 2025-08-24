<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Spt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function create(){
        return view('superadmin.account');
    }

    public function store(Request $request){
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'role' => 'admin', // ⬅️ otomatis admin
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('superadmin.account')->with('success', 'Akun admin berhasil dibuat.');
    }

    public function index(){
        $spts = Spt::with('pegawais')->latest()->get();     // surat terbaru ada di atas
        return view('superadmin.viewSpt', compact('spts'));
    }

     public function requestIndex(){
        // ambil semua data SPT yang butuh approval
        $spts = Spt::where('status', 'menunggu')->latest()->get();

        return view('superadmin.request', compact('spts'));
    }

    public function setSigner(Request $request, $id){
        $validated = $request->validate([
            'penandatangan' => 'nullable|in:kepala, sekretaris'
        ]);

        $spt = Spt::findOrFail($id);
        $spt->penandatangan = $validated['penandatangan'];
        $spt->save();

        return back()->with('success', 'Penandatangan berhasil diperbarui');
    }


    public function approve($id){
        $spt = Spt::findOrFail($id);
        $spt->update(['status' => 'disetujui']);

        return redirect()->route('superadmin.viewSpt.index')->with('success', 'SPT berhasil disetujui.');
    }

    public function reject($id){
        $spt = Spt::findOrFail($id);
        $spt->update(['status' => 'ditolak']);

        return redirect()->route('superadmin.viewSpt.index')->with('success', 'SPT berhasil ditolak.');
    }

}
