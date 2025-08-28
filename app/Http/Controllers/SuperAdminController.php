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

     public function requestIndex(){
        $spts = Spt::where('status', 'menunggu')->with('penandatangan')->latest()->get();
        $penandatangans = \App\Models\Penandatangan::all();

        return view('superadmin.request', compact('spts', 'penandatangans'));
    }

    public function setSigner(Request $request, $id){
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
        $spt = Spt::with(['pegawais', 'penandatangan'])->findOrFail($id);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop'    => 1000,
            'marginBottom' => 800,
            'marginLeft'   => 1000,
            'marginRight'  => 800,
            'paperSize'    => 'A4',
        ]);

        // Kop Surat
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(2000, ['valign' => 'center'])->addImage(public_path('images/logo-dinsos.png'), [
            'width' => 70,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        ]);

        $cell = $table->addCell(10000);
        $noSpace = ['alignment' => 'center', 'spaceAfter' => 0, 'lineHeight' => 1.0];
        $cell->addText('PEMERINTAH PROVINSI JAWA TIMUR', ['bold' => true, 'size' => 14], $noSpace);
        $cell->addText('DINAS SOSIAL', ['bold' => true, 'size' => 14], $noSpace);
        $cell->addText('Jalan Gayung Kebonsari Nomor 56 B, Gayungan, Surabaya, Jawa Timur 60235', [],  $noSpace);
        $cell->addText('Telepon (031) 8290734 / 8296515, Laman http://dinsos.jatimprov.go.id', [], $noSpace);
        $cell->addText('Pos-el dinsosjatim56b@gmail.com', [], $noSpace);

        // Judul Surat
        $section->addText('SURAT TUGAS', ['bold' => true, 'underline' => 'single', 'size' => 13], ['alignment' => 'center']);
        $section->addText("NOMOR : " . $spt->nomor_surat, [], ['alignment' => 'center']);

        // DASAR
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(1500)->addText('DASAR', ['bold' => false], ['alignment' => 'left']);
        $table->addCell(300)->addText(':');
        $dasarCell = $table->addCell(12000);
        $innerTable = $dasarCell->addTable();
        $list = explode("\n", $spt->dasar);
        $no = 1;
        foreach ($list as $d) {
            $innerTable->addRow();
            $innerTable->addCell(300)->addText($no . '.', null, [
                'alignment' => 'left',
                'spaceAfter' => 0,
                'lineHeight' => 1.15
            ]);
            $innerTable->addCell(11500)->addText($d, null, [
                'alignment' => 'both',
                'spaceAfter' => 0,
                'lineHeight' => 1.15
            ]);
            $no++;
        }

        // MEMERINTAHKAN
        $section->addText('MEMERINTAHKAN', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0, 'spaceBefore' => 100]);

        // KEPADA
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(1500)->addText('KEPADA');
        $table->addCell(300)->addText(':');
        $cell = $table->addCell(12000);

        $no = 1;
        foreach ($spt->pegawais as $p) {
            $cell->addText($no . '. Nama           : ' . $p->nama, null, [
                'alignment' => 'both',
                'spaceAfter' => 0,
                'lineHeight' => 1.15
            ]);
            // NIP
            $nipText = $p->nip ? "    NIP               : {$p->nip}" : ($p->niptt_pk ? "    NIPTT-PK    : {$p->niptt_pk}" : "    NIP : -");
            $cell->addText($nipText, null, ['alignment' => 'both', 'spaceAfter' => 0, 'lineHeight' => 1.15]);
            // Jabatan
            $cell->addText("    Jabatan        : " . ($p->jabatan ?? "-"), null, ['alignment' => 'both', 'spaceAfter' => 0, 'lineHeight' => 1.15]);
            // Pangkat/Gol
            $cell->addText("    Pangkat/Gol : " . ($p->pangkat_gol ?? "-"), null, ['alignment' => 'both', 'spaceAfter' => 0, 'lineHeight' => 1.15]);

            $no++;
        }

        // UNTUK
        $table->addRow();
        $table->addCell(1500)->addText('UNTUK');
        $table->addCell(300)->addText(':');
        $table->addCell(12000)->addText($spt->untuk, [], ['align' => 'both']);

        // Tempat, tanggal, dan tanda tangan
        $indent = ['indentation' => ['left' => 6000], 'spaceAfter' => 0];

        $section->addText("Ditetapkan di : {$spt->ditetapkan_di}", [], $indent);
        $section->addText("Pada tanggal : " . \Carbon\Carbon::parse($spt->tanggal)->translatedFormat('d F Y'), [], $indent);
        $section->addText("a.n. Kepala Dinas Sosial", [], $indent);
        $section->addText("Provinsi Jawa Timur", [], $indent);
        if ($spt->penandatangan) {
            $section->addText($spt->penandatangan->jabatan, [], $indent);
        }

        $section->addTextBreak(3);

        if ($spt->penandatangan) {
            $section->addText($spt->penandatangan->nama, ['bold' => false], $indent);
            $section->addText($spt->penandatangan->pangkat_gol, [], $indent);
            $section->addText("NIP. " . $spt->penandatangan->nip, [], $indent);
        } else {
            $section->addText("____________________", [], $indent);
            $section->addText("Pangkat/Gol: __________", [], $indent);
            $section->addText("NIP. __________", [], ['alignment' => 'left', 'spaceAfter' => 0]);
        }

        // Export
        $filename = 'Surat_Tugas_' . $spt->nomor_surat . '.docx';
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save("php://output");
        exit;
    }
}
