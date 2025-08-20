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
                <li>
                    {{ !empty($report->foto_kegiatan) ? '✔ Foto Kegiatan' : '✘ Foto Kegiatan' }}
                    @if(!empty($report->foto_kegiatan))
                        <div class="ms-4">
                            <a href="{{ asset('storage/'.$report->foto_kegiatan) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a> |
                            <a href="{{ asset('storage/'.$report->foto_kegiatan) }}" download class="btn btn-sm btn-success">Download</a>
                        </div>
                    @endif
                </li>

                <li>
                    {{ !empty($report->scan_hardcopy) ? '✔ Scan Hardcopy' : '✘ Scan Hardcopy' }}
                    @if(!empty($report->scan_hardcopy))
                        <div class="ms-4">
                            <a href="{{ asset('storage/'.$report->scan_hardcopy) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a> |
                            <a href="{{ asset('storage/'.$report->scan_hardcopy) }}" download class="btn btn-sm btn-success">Download</a>
                        </div>
                    @endif
                </li>

                <li>
                    {{ !empty($report->e_toll) ? '✔ E-Toll' : '✘ E-Toll' }}
                    @if(!empty($report->e_toll))
                        <div class="ms-4">
                            <a href="{{ asset('storage/'.$report->e_toll) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a> |
                            <a href="{{ asset('storage/'.$report->e_toll) }}" download class="btn btn-sm btn-success">Download</a>
                        </div>
                    @endif
                </li>

                <li>
                    {{ !empty($report->bbm) ? '✔ BBM' : '✘ BBM' }}
                    @if(!empty($report->bbm))
                        <div class="ms-4">
                            <a href="{{ asset('storage/'.$report->bbm) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a> |
                            <a href="{{ asset('storage/'.$report->bbm) }}" download class="btn btn-sm btn-success">Download</a>
                        </div>
                    @endif
                </li>
            </ul>

            <a href="{{ route('report.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
