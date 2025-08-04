@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Detail Laporan Perjalanan Dinas</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Nomor Surat:</strong> 000.4.5.6/7712/109.3/2025</p>
            <p><strong>Tanggal Laporan:</strong> 2025-06-17</p>
            <p><strong>Nama Pelapor:</strong> Andi Wijaya</p>

            <hr>

            <h5>Checklist Dokumen:</h5>
            <ul>
                <li>✔ Foto Kegiatan</li>
                <li>✔ Scan Hardcopy</li>
                <li>✘ E-Toll</li>
                <li>✔ BBM</li>
            </ul>

            <hr>

            <a href="/view" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
