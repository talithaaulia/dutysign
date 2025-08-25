@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; background: #fff; padding: 40px; border: 1px solid #000;">

    {{-- Kop Surat --}}
    <div class="text-center mb-4">
        <h5 class="mb-0">PEMERINTAH PROVINSI JAWA TIMUR</h5>
        <h5 class="mb-0">DINAS SOSIAL</h5>
        <p class="mb-0">Jalan Gayung Kebonsari Nomor 56 B, Gayungan, Surabaya, Jawa Timur 60235</p>
        <p class="mb-0">Telepon (031) 8290734 / 8296515, Email: dinsos.jatimprov.go.id</p>
        <hr style="border:1px solid #000">
    </div>

    {{-- Judul Surat --}}
    <div class="text-center mb-4">
        <h5><u>SURAT TUGAS</u></h5>
        <p>Nomor: {{ $spt->nomor_surat }}</p>
    </div>

    {{-- Dasar --}}
    <table class="mb-3" style="width:100%">
    <tr>
        <td style="width:120px; vertical-align: top;"><strong>DASAR :</strong></td>
        <td>
            <ol style="margin:0; padding-left:15px;">
                @foreach(explode("\n", $spt->dasar) as $d)
                    <li>{{ $d }}</li>
                @endforeach
            </ol>
        </td>
    </tr>
</table>

    <div class="text-center mb-4">
        <h5><u>MEMERINTAHKAN</u></h5>
    </div>

    {{-- KEPADA --}}
<table class="mb-3" style="width:100%">
    <tr>
        <td style="width:120px; vertical-align: top;"><strong>KEPADA :</strong></td>
        <td>
            <ol style="margin:0; padding-left:15px;">
                @foreach($spt->pegawais as $p)
                    <li>{{ $p->nama }} - {{ $p->jabatan ?? '-' }}</li>
                @endforeach
            </ol>
        </td>
    </tr>
</table>

{{-- UNTUK --}}
<table class="mb-3" style="width:100%">
    <tr>
        <td style="width:120px; vertical-align: top;"><strong>UNTUK :</strong></td>
        <td>{{ $spt->untuk }}</td>
    </tr>
</table>

    {{-- Tanggal & Tempat --}}
    <div class="text-end mt-5">
    <p>Ditetapkan di: {{ $spt->ditetapkan_di }} <br>
        Pada tanggal: {{ \Carbon\Carbon::parse($spt->tanggal)->translatedFormat('d F Y') }} <br>
        a.n. Kepala Dinas Sosial <br>
        Provinsi Jawa Timur
    </p>

    {{-- jabatan penandatangan --}}
    @if($spt->status == 'disetujui' && $spt->penandatangan_nama)
    <strong>{{ $spt->penandatangan_nama }}</strong><br>
    {{ ucfirst($spt->penandatangan) }}
@else
    [Silakan pilih penandatangan]
@endif


    <br><br><br>

    <p>
        <u>
        @if($spt->status == 'disetujui' && $spt->penandatangan)
            {{ $spt->penandatangan }}
        @else
            ______________________
        @endif
        </u>
    </p>
</div>


    {{-- File Scan Asli --}}
    <div class="mt-5">
        <strong>Scan Surat (Sudah TTD+Stempel):</strong><br>
        @if($spt->file_scan)
            <a href="{{ route('spt.download', $spt->id) }}" class="btn btn-sm btn-success mt-2">Download</a>
        @else
            <span class="text-muted">Belum ada</span>
        @endif
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-3">
        @if(Auth::user()->role === 'super_admin')
            <a href="{{ route('superadmin.viewSpt.index') }}" class="btn btn-secondary">Kembali</a>
        @else
            <a href="{{ route('spt.index') }}" class="btn btn-secondary">Kembali</a>
        @endif
    </div>

</div>
@endsection
