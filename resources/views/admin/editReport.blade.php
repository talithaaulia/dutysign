@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Edit Laporan Perjalanan Dinas</h3>

    <form action="{{ route('report.update', $report->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h5>Data Laporan</h5>
                <div class="mb-3">
                    <label class="form-label">Dasar</label>
                    <input type="text" class="form-control" value="{{ $report->spt->nomor_surat }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Maksud Tujuan</label>
                    <textarea name="maksud_tujuan" class="form-control">{{ old('maksud_tujuan', $report->maksud_tujuan) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu Pelaksanaan</label>
                    <textarea name="waktu_pelaksanaan" class="form-control">{{ old('waktu_pelaksanaan', $report->waktu_pelaksanaan) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="nama_petugas" class="form-label">Nama Petugas</label>
                    <div class="form-control">
                        @if($report->spt && $report->spt->pegawais->count())
                            <ol class="mb-0 ps-3">
                                @foreach($report->spt->pegawais as $pegawai)
                                    <li>{{ $pegawai->nama }}</li>
                                @endforeach
                            </ol>
                        @else
                            <span class="text-muted">Tidak ada petugas</span>
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Daerah Tujuan/Instansi yang Dikunjungi</label>
                    <textarea name="daerah_tujuan" class="form-control">{{ old('daerah_tujuan', $report->daerah_tujuan) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hadir dalam Pertemuan</label>
                    <textarea name="hadir" class="form-control">{{ old('hadir', $report->hadir) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Petunjuk/Arahan yang Diberikan</label>
                    <textarea name="petunjuk" class="form-control">{{ old('petunjuk', $report->petunjuk) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Masalah dan Temuan</label>
                    <textarea name="masalah" class="form-control">{{ old('masalah', $report->masalah) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Saran dan Tindakan</label>
                    <textarea name="saran" class="form-control">{{ old('saran', $report->saran) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Lain-Lain</label>
                    <textarea name="lain_lain" class="form-control">{{ old('lain_lain', $report->lain_lain) }}</textarea>
                </div>

                <h5 class="mt-4">Checklist Laporan</h5>

{{-- Foto Kegiatan --}}
<div class="mb-3">
    <label class="form-label fw-semibold d-block">Foto Kegiatan</label>
    <div id="foto-kegiatan-wrapper">
        <div class="input-group mb-2">
            <input type="file" name="foto_kegiatan[]" class="form-control" accept="image/*">
            <button type="button" class="btn btn-outline-danger remove-input">x</button>
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-secondary" onclick="addInput('foto-kegiatan-wrapper','foto_kegiatan[]','image/*')">+ Tambah Foto</button>
</div>

{{-- Scan Hardcopy Laporan --}}
<div class="mb-3">
    <label class="form-label fw-semibold d-block">Scan Hardcopy Laporan</label>
    <div id="scan-laporan-wrapper">
        <div class="input-group mb-2">
            <input type="file" name="scan_hardcopy[]" class="form-control" accept=".pdf,.jpg,.png">
            <button type="button" class="btn btn-outline-danger remove-input">x</button>
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-secondary" onclick="addInput('scan-laporan-wrapper','scan_hardcopy[]','.pdf,.jpg,.png')">+ Tambah Scan</button>
</div>

{{-- Biaya E-Toll --}}
<div class="mb-3">
    <label class="form-label fw-semibold d-block">Biaya E-Toll (Jika Ada)</label>
    <div id="etoll-wrapper">
        <div class="input-group mb-2">
            <input type="file" name="e_toll[]" class="form-control" accept=".pdf,.jpg,.png">
            <button type="button" class="btn btn-outline-danger remove-input">x</button>
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-secondary" onclick="addInput('etoll-wrapper','e_toll[]','.pdf,.jpg,.png')">+ Tambah E-Toll</button>
</div>

{{-- Biaya BBM --}}
<div class="mb-3">
    <label class="form-label fw-semibold d-block">Biaya BBM (Jika Ada)</label>
    <div id="bbm-wrapper">
        <div class="input-group mb-2">
            <input type="file" name="bbm[]" class="form-control" accept=".pdf,.jpg,.png">
            <button type="button" class="btn btn-outline-danger remove-input">x</button>
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-secondary" onclick="addInput('bbm-wrapper','bbm[]','.pdf,.jpg,.png')">+ Tambah BBM</button>
</div>

{{-- Script Dinamis --}}
<script>
    function addInput(wrapperId, name, accept, required = false) {
        const wrapper = document.getElementById(wrapperId);
        const div = document.createElement('div');
        div.classList.add('input-group','mb-2');
        div.innerHTML = `
            <input type="file" name="${name}" class="form-control" accept="${accept}" ${required ? 'required' : ''}>
            <button type="button" class="btn btn-outline-danger remove-input">x</button>
        `;
        wrapper.appendChild(div);
    }

    // event listener global buat tombol hapus
    document.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('remove-input')) {
            e.target.parentElement.remove();
        }
    });
</script>

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('report.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</div>
@endsection