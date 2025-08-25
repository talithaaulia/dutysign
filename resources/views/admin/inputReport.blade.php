@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Input Laporan Perjalanan Dinas</h3>

    <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h5>Data SPT</h5>
                <div class="mb-3">
                    <label for="spt_id" class="form-label">Pilih SPT</label>
                    <select name="spt_id" id="spt_id" class="form-select" required>
                        <option value="">-- Pilih SPT --</option>
                        @foreach (\App\Models\Spt::with('pegawais')->get() as $spt)
                            <option value="{{  $spt->id }}">
                                {{ $spt->nomor_surat }} - {{ $spt->tanggal }}
                                (@foreach ($spt->pegawais as $pegawai) {{ $pegawai->nama }} @endforeach)
                            </option>
                        @endforeach
                    </select>
                </div>

                <h5>Data Laporan</h5>
                <div class="mb-3">
                    <label class="form-label">Dasar</label>
                    <textarea name="dasar" class="form-control">{{ old('dasar') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Maksud Tujuan</label>
                    <textarea name="maksud_tujuan" class="form-control">{{ old('maksud_tujuan') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu Pelaksanaan</label>
                    <textarea name="waktu_pelaksanaan" class="form-control">{{ old('waktu_pelaksanaan') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Petugas</label>
                    <textarea name="nama_petugas" class="form-control">{{ old('nama_petugas') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Daerah Tujuan/Instansi yang Dikunjungi</label>
                    <textarea name="daerah_tujuan" class="form-control">{{ old('daerah_tujuan') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hadir dalam Pertemuan</label>
                    <textarea name="hadir" class="form-control">{{ old('hadir') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Petunjuk/Arahan yang Diberikan</label>
                    <textarea name="petunjuk" class="form-control">{{ old('petunjuk') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Masalah dan Temuan</label>
                    <textarea name="masalah" class="form-control">{{ old('masalah') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Saran dan Tindakan</label>
                    <textarea name="saran" class="form-control">{{ old('saran') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Lain-Lain</label>
                    <textarea name="lain_lain" class="form-control">{{ old('lain_lain') }}</textarea>
                </div>

                <h5 class="mt-4">Checklist Laporan</h5>

{{-- Foto Kegiatan --}}
<div class="mb-3">
    <label class="form-label fw-semibold d-block">Foto Kegiatan <span class="text-danger">*</span></label>
    <div id="foto-kegiatan-wrapper">
        <div class="input-group mb-2">
            <input type="file" name="foto_kegiatan[]" class="form-control" accept="image/*" required>
            <button type="button" class="btn btn-outline-danger remove-input">x</button>
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-secondary" onclick="addInput('foto-kegiatan-wrapper','foto_kegiatan[]','image/*',true)">+ Tambah Foto</button>
</div>

{{-- Scan Hardcopy Laporan --}}
<div class="mb-3">
    <label class="form-label fw-semibold d-block">Scan Hardcopy Laporan <span class="text-danger">*</span></label>
    <div id="scan-laporan-wrapper">
        <div class="input-group mb-2">
            <input type="file" name="scan_hardcopy[]" class="form-control" accept=".pdf,.jpg,.png" required>
            <button type="button" class="btn btn-outline-danger remove-input">x</button>
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-secondary" onclick="addInput('scan-laporan-wrapper','scan_hardcopy[]','.pdf,.jpg,.png',true)">+ Tambah Scan</button>
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

                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection