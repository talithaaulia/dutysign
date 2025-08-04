@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Edit Laporan Perjalanan Dinas</h3>

    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- NOMOR SURAT --}}
        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat</label>
            <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" value="000.4.5.6/7712/109.3/2025" required>
        </div>

        {{-- TANGGAL LAPORAN --}}
        <div class="mb-3">
            <label for="tanggal_laporan" class="form-label">Tanggal Laporan</label>
            <input type="date" name="tanggal_laporan" id="tanggal_laporan" class="form-control" value="2025-06-17" required>
        </div>

        {{-- NAMA PELAPOR --}}
        <div class="mb-3">
            <label for="nama_pelapor" class="form-label">Nama Pelapor</label>
            <input type="text" name="nama_pelapor" id="nama_pelapor" class="form-control" value="Andi Wijaya" required>
        </div>

        {{-- CHECKLIST --}}
        <div class="mb-3">
            <label class="form-label">Checklist Dokumen</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="checklist[]" value="foto_kegiatan" id="foto_kegiatan" checked>
                <label class="form-check-label" for="foto_kegiatan">Foto Kegiatan</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="checklist[]" value="scan_hardcopy" id="scan_hardcopy" checked>
                <label class="form-check-label" for="scan_hardcopy">Scan Hardcopy</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="checklist[]" value="etoll" id="etoll">
                <label class="form-check-label" for="etoll">E-Toll</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="checklist[]" value="bbm" id="bbm" checked>
                <label class="form-check-label" for="bbm">BBM</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="/view" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
