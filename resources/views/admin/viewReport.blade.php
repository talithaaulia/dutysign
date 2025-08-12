@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Laporan Perjalanan Dinas</h3>

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
        <td>{{ $report->nomor_surat }}</td>
        <td>{{ $report->tanggal_laporan }}</td>
        <td>{{ $report->nama_pelapor }}</td>
        <td class="text-justify">
            <ul>
                <li>{{ $report->foto_kegiatan ? '✔ Foto Kegiatan' : '✘ Foto Kegiatan' }}</li>
                <li>{{ $report->scan_hardcopy ? '✔ Scan Hardcopy' : '✘ Scan Hardcopy' }}</li>
                <li>{{ $report->e_toll ? '✔ E-Toll' : '✘ E-Toll' }}</li>
                <li>{{ $report->bbm ? '✔ BBM' : '✘ BBM' }}</li>
            </ul>
        </td>
        <td class="text-center">
            <a href="/detailreport" class="btn btn-sm btn-info mb-1">Lihat</a>
            <a href="/editreport" class="btn btn-sm btn-warning mb-1">Edit</a>
            <form action="{{ route('report.destroy', $report->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus laporan ini?')">Hapus</button>
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
