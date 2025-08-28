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
                        @foreach (\App\Models\Spt::with('pegawais')->latest()->get() as $spt)
                            <option
                                value="{{ $spt->id }}"
                                data-nomor="{{ $spt->nomor_surat }}"
                                {{-- kirim sebagai JSON array supaya koma di gelar tdk bikin pecah --}}
                                data-petugas='@json($spt->pegawais->pluck("nama")->values())'>
                                {{ $spt->nomor_surat }} - {{ $spt->tanggal }}
                                (
                                    @foreach ($spt->pegawais as $pegawai)
                                        {{ $pegawai->nama }}@if(!$loop->last), @endif
                                    @endforeach
                                )
                            </option>
                        @endforeach
                    </select>
                </div>

                <h5>Data Laporan</h5>
                <div class="mb-3">
                    <label class="form-label">Dasar</label>
                    <input type="text" id="dasar_auto" class="form-control" readonly>
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
                    {{-- dibuat textarea biar bisa multiline & tetap form-control seperti "Dasar" --}}
                    <textarea id="petugas_auto" class="form-control" rows="2" readonly></textarea>
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
                    <button type="button" class="btn btn-sm btn-secondary"
                            onclick="addInput('foto-kegiatan-wrapper','foto_kegiatan[]','image/*',true)">+ Tambah Foto</button>
                </div>

                {{-- Scan Hardcopy --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold d-block">Scan Hardcopy Laporan <span class="text-danger">*</span></label>
                    <div id="scan-laporan-wrapper">
                        <div class="input-group mb-2">
                            <input type="file" name="scan_hardcopy[]" class="form-control" accept=".pdf,.jpg,.png" required>
                            <button type="button" class="btn btn-outline-danger remove-input">x</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary"
                            onclick="addInput('scan-laporan-wrapper','scan_hardcopy[]','.pdf,.jpg,.png',true)">+ Tambah Scan</button>
                </div>

                {{-- E-Toll --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold d-block">Biaya E-Toll (Jika Ada)</label>
                    <div id="etoll-wrapper">
                        <div class="input-group mb-2">
                            <input type="file" name="e_toll[]" class="form-control" accept=".pdf,.jpg,.png">
                            <button type="button" class="btn btn-outline-danger remove-input">x</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary"
                            onclick="addInput('etoll-wrapper','e_toll[]','.pdf,.jpg,.png')">+ Tambah E-Toll</button>
                </div>

                {{-- BBM --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold d-block">Biaya BBM (Jika Ada)</label>
                    <div id="bbm-wrapper">
                        <div class="input-group mb-2">
                            <input type="file" name="bbm[]" class="form-control" accept=".pdf,.jpg,.png">
                            <button type="button" class="btn btn-outline-danger remove-input">x</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary"
                            onclick="addInput('bbm-wrapper','bbm[]','.pdf,.jpg,.png')">+ Tambah BBM</button>
                </div>

                {{-- Script Dinamis + Auto Fill --}}
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

                    // hapus baris file
                    document.addEventListener('click', function(e) {
                        if (e.target && e.target.classList.contains('remove-input')) {
                            e.target.parentElement.remove();
                        }
                    });

                    // ==== Auto isi dasar & nama petugas (pakai JSON, bukan split koma) ====
                    const sptSelect = document.getElementById('spt_id');
                    const dasarInput = document.getElementById('dasar_auto');
                    const petugasTA  = document.getElementById('petugas_auto');

                    function fillFromOption(opt) {
                        if (!opt) return;

                        // Dasar
                        dasarInput.value = opt.dataset.nomor || '';

                        // Nama petugas (JSON)
                        let list = [];
                        try {
                            list = JSON.parse(opt.dataset.petugas || '[]');
                        } catch (e) {
                            // fallback kalau ada kasus lama
                            const raw = (opt.dataset.petugas || '');
                            list = raw.split(',').map(s => s.trim()).filter(Boolean);
                        }

                        const numbered = list.map((name, i) => `${i+1}. ${name}`).join('\n');
                        petugasTA.value = numbered;

                        // resize rows biar rapi
                        petugasTA.rows = Math.max(2, list.length);
                    }

                    sptSelect.addEventListener('change', function () {
                        fillFromOption(this.options[this.selectedIndex]);
                    });

                    // jika sudah ada nilai (mis. old value), isi saat halaman pertama kali dibuka
                    if (sptSelect.value) {
                        fillFromOption(sptSelect.options[sptSelect.selectedIndex]);
                    }
                </script>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection
