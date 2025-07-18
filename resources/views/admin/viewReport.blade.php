@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Laporan Perjalanan Dinas</h3>

    {{-- Alert dummy --}}
    {{-- <div class="alert alert-success">Laporan berhasil dihapus.</div> --}}

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
                    <th>Berkas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contoh data dummy --}}
                <tr>
                    <td class="text-center">1</td>
                    <td>000.4.5.6/7712/109.3/2025</td>
                    <td>2025-06-17</td>
                    <td>Talitha A</td>
                    <td>
                        <ul>
                            <li>✔ Foto Kegiatan</li>
                            <li>✔ Scan Hardcopy</li>
                            <li>✘ E-Toll</li>
                            <li>✔ BBM</li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li><a href="#">Foto Kegiatan</a></li>
                            <li><a href="#">Scan Hardcopy</a></li>
                            <li><span class="text-muted">Tidak Ada E-Toll</span></li>
                            <li><a href="#">Bukti BBM</a></li>
                        </ul>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btn btn-sm btn-info mb-1">Lihat</a>
                        <a href="#" class="btn btn-sm btn-warning mb-1">Edit</a>
                        <form action="#" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus laporan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
@endsection
