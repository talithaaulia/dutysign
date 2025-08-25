@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Detail Laporan Perjalanan Dinas</h3>

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h5>Data Laporan</h5>
            <p><strong>Dasar:</strong> {{ $report->dasar }}</p>
            <p><strong>Maksud Tujuan:</strong> {{ $report->maksud_tujuan }}</p>
            <p><strong>Waktu Pelaksanaan:</strong> {{ $report->waktu_pelaksanaan }}</p>
            <p><strong>Nama Petugas:</strong> {{ $report->nama_petugas }}</p>
            <p><strong>Daerah Tujuan:</strong> {{ $report->daerah_tujuan }}</p>
            <p><strong>Hadir:</strong> {{ $report->hadir }}</p>
            <p><strong>Petunjuk:</strong> {{ $report->petunjuk }}</p>
            <p><strong>Masalah:</strong> {{ $report->masalah }}</p>
            <p><strong>Saran:</strong> {{ $report->saran }}</p>
            <p><strong>Lain-lain:</strong> {{ $report->lain_lain }}</p>

            <h5 class="mt-4">Checklist Laporan</h5>

            {{-- Foto Kegiatan --}}
            <div class="mb-3">
                <strong>Foto Kegiatan:</strong><br>
                @forelse ($report->foto_kegiatan as $file)
                    @php $basename = basename($file); @endphp
                    <div class="mb-2">
                        <a href="{{ asset('storage/'.$file) }}" target="_blank">📄 Lihat File</a> |
                        <a href="{{ route('report.download',['folder'=>'foto','filename'=>$basename]) }}" 
                           class="text-decoration-none">⬇️ Download</a>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada file.</p>
                @endforelse
            </div>

            {{-- Scan Hardcopy --}}
            <div class="mb-3">
                <strong>Scan Hardcopy:</strong><br>
                @forelse ($report->scan_hardcopy as $file)
                    @php $basename = basename($file); @endphp
                    <div class="mb-2">
                        <a href="{{ asset('storage/'.$file) }}" target="_blank">📄 Lihat File</a> |
                        <a href="{{ route('report.download',['folder'=>'scan','filename'=>$basename]) }}" 
                           class="text-decoration-none">⬇️ Download</a>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada file.</p>
                @endforelse
            </div>

            {{-- E-Toll --}}
            <div class="mb-3">
                <strong>E-Toll:</strong><br>
                @forelse ($report->e_toll as $file)
                    @php $basename = basename($file); @endphp
                    <div class="mb-2">
                        <a href="{{ asset('storage/'.$file) }}" target="_blank">📄 Lihat File</a> |
                        <a href="{{ route('report.download',['folder'=>'etoll','filename'=>$basename]) }}" 
                           class="text-decoration-none">⬇️ Download</a>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada file.</p>
                @endforelse
            </div>

            {{-- BBM --}}
            <div class="mb-3">
                <strong>BBM:</strong><br>
                @forelse ($report->bbm as $file)
                    @php $basename = basename($file); @endphp
                    <div class="mb-2">
                        <a href="{{ asset('storage/'.$file) }}" target="_blank">📄 Lihat File</a> |
                        <a href="{{ route('report.download',['folder'=>'bbm','filename'=>$basename]) }}" 
                           class="text-decoration-none">⬇️ Download</a>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada file.</p>
                @endforelse
            </div>

            <a href="{{ route('report.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
