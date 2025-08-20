@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Detail Laporan Perjalanan Dinas</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Nomor Surat:</strong> {{ $report->spt->nomor_surat ?? '-' }}</p>
            <p><strong>Tanggal Laporan:</strong> {{ $report->spt->tanggal ?? '-' }}</p>
            <p><strong>Nama Pelapor:</strong>
                @foreach ($report->spt->pegawais as $pegawai)
                    {{ $pegawai->nama }}
                @endforeach
            </p>

            <hr>

            <h5>Checklist Dokumen:</h5>
            <ul>
                <li>{{ $report->foto_kegiatan ? '✔ Foto Kegiatan' : '✘ Foto Kegiatan' }}</li>
                <li>{{ $report->scan_hardcopy ? '✔ Scan Hardcopy' : '✘ Scan Hardcopy' }}</li>
                <li>{{ $report->e_toll ? '✔ E-Toll' : '✘ E-Toll' }}</li>
                <li>{{ $report->bbm ? '✔ BBM' : '✘ BBM' }}</li>
            </ul>

            <hr>

            <a href="{{ route('report.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
