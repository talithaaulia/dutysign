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
                <tr>
                    <td>1</td>
                    <td>000.4.5.6/7712/109.3/2025</td>
                    <td>2025-06-17</td>
                    <td>Andi Wijaya</td>
                    <td class="text-justify">
                        <ul>
                            <li>✔ Foto Kegiatan</li>
                            <li>✔ Scan Hardcopy</li>
                            <li>✘ E-Toll</li>
                            <li>✔ BBM</li>
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
