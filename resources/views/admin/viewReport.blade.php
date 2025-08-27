@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Laporan Perjalanan Dinas</h3>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Tabel laporan --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal Laporan</th>
                    <th>Nama Pelapor</th>
                    <th>Checklist</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
@forelse ($reports as $index => $report)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $report->spt->nomor_surat ?? '-' }}</td>
        <td>{{ $report->spt->tanggal ?? '-' }}</td>
        <td class="text-start">
            @foreach($report->spt->pegawais as $pegawai)
                {{$pegawai->nama}} <br>
            @endforeach            
        </td>
        <td class="text-justify">
            <ul>
                <li>{{ $report->foto_kegiatan ? '✔ Foto Kegiatan' : '✘ Foto Kegiatan' }}</li>
                <li>{{ $report->scan_hardcopy ? '✔ Scan Hardcopy' : '✘ Scan Hardcopy' }}</li>
                <li>{{ $report->e_toll ? '✔ E-Toll' : '✘ E-Toll' }}</li>
                <li>{{ $report->bbm ? '✔ BBM' : '✘ BBM' }}</li>
            </ul>
        </td>
        <td class="text-center">
    <a href="{{ route('report.show', $report->id) }}" class="btn btn-sm btn-info mb-1">Lihat</a>
    <a href="{{ route('report.edit', $report->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>

    <form action="{{ route('report.destroy', $report->id) }}" method="POST" class="d-inline delete-confirm">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger mb-1">Hapus</button>
    </form>
</td>

    </tr>
@empty
    <tr>
        <td colspan="6">Belum ada laporan</td>
    </tr>
@endforelse
</tbody>

        </table>
    </div>
</div>
@endsection
