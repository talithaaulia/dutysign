<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Spt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

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

     public function requestIndex()
{
    $spts = Spt::where('status', 'menunggu')->with('penandatangan')->latest()->get();
    $penandatangans = \App\Models\Penandatangan::all();

    return view('superadmin.request', compact('spts', 'penandatangans'));
}

    public function setSigner(Request $request, $id)
{
    $validated = $request->validate([
        'penandatangan_id' => 'required|exists:penandatangan,id',
    ]);

    $spt = Spt::findOrFail($id);
    $spt->penandatangan_id = $validated['penandatangan_id']; // simpan foreign key
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

    public function preview($id){
        $spt = Spt::with('pegawais')->findOrFail($id);
        $spt->signer_data = $spt->penandatangan();

        return view('superadmin.preview', compact('spt'));
    }

    public function exportWord($id){
        $spt = Spt::with('pegawais')->findOrFail($id);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText("PEMERINTAH PROVINSI JAWA TIMUR", ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $section->addText("DINAS SOSIAL", ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $section->addText("SURAT TUGAS", ['bold' => true, 'underline' => 'single', 'size' => 14], ['alignment' => 'center']);
        $section->addText("Nomor: {$spt->nomor_surat}", ['size' => 12], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $section->addText("DASAR :");
        foreach (explode("\n", $spt->dasar) as $d) {
            $section->addListItem($d, 0, ['size' => 12]);
        }

        $section->addTextBreak(1);
        $section->addText("MEMERINTAHKAN:", ['bold' => true, 'alignment' => 'center']);
        $section->addText("KEPADA :");
        foreach ($spt->pegawais as $p) {
            $section->addListItem("{$p->nama} - {$p->jabatan}");
        }

        $section->addTextBreak(1);
        $section->addText("UNTUK :");
        $section->addText($spt->untuk);

        $section->addTextBreak(2);
        $section->addText("Ditetapkan di: {$spt->ditetapkan_di}");
        $section->addText("Pada tanggal: " . \Carbon\Carbon::parse($spt->tanggal)->translatedFormat('d F Y'));

        $fileName = "SPT-{$spt->nomor_surat}.docx";

        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save("php://output");
    }
}
