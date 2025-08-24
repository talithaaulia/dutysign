@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Surat Perintah Tugas</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('spt.update', $spt->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat</label>
            <input type="text" name="nomor_surat" class="form-control" value="{{ old('nomor_surat', $spt->nomor_surat) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Dasar</label>
            <div id="dasar-container">
                @php
                    $dasars = explode("\n", $spt->dasar ?? '');
                @endphp
                @foreach ($dasars as $i => $dasar)
                    <div class="row mb-2 dasar-item align-items-start">
                        <div class="col-auto pt-2 dasar-number">{{ $i+1 }}.</div>
                        <div class="col">
                            <textarea name="dasar[]" class="form-control" required>{{ $dasar }}</textarea>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-danger" onclick="hapusDasar(this)">&times;</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="tambahDasar()">+ Tambah Dasar</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Kepada (Pegawai yang Ditugaskan)</label>
            <div id="kepada-container">
                @foreach ($spt->pegawaiSpt as $i => $kepada)
                    <div class="row mb-2 kepada-row g-2 align-items-end">
                        <div class="col-md-3">
                            <select name="kepada[{{ $i }}][pegawai_id]" class="form-select pegawai-select" required data-index="{{ $i }}">
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}" data-nip="{{ $pegawai->nip ?? $pegawai->niptt_pk }}"
                                        {{ $pegawai->id == $kepada->pegawai_id ? 'selected' : '' }}>
                                        {{ $pegawai->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="kepada[{{ $i }}][pangkat_gol]" class="form-select" required>
                                <option value="">-- Pilih Pangkat/Gol --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->pangkat_gol }}"
                                        {{ $pegawai->pangkat_gol == $kepada->pangkat_gol ? 'selected' : '' }}>
                                        {{ $pegawai->pangkat_gol }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="kepada[{{ $i }}][nip]" class="form-control nip"
                                value="{{ $kepada->nip ?? $kepada->niptt_pk }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <select name="kepada[{{ $i }}][jabatan]" class="form-select" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->jabatan }}"
                                        {{ $pegawai->jabatan == $kepada->jabatan ? 'selected' : '' }}>
                                        {{ $pegawai->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-danger" onclick="hapusKepada(this)">&times;</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="tambahKepada()">+ Tambah Pegawai</button>
        </div>

        <div class="mb-3">
            <label for="untuk" class="form-label">Untuk</label>
            <textarea name="untuk" class="form-control" rows="3">{{ old('untuk', $spt->untuk) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="ditetapkan_di" class="form-label">Ditetapkan di</label>
            <input type="text" name="ditetapkan_di" class="form-control" value="{{ old('ditetapkan_di', $spt->ditetapkan_di) }}">
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Surat</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $spt->tanggal) }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" id="disabledTextInput" class="form-control" placeholder="{{ $spt->status }}" disabled>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('spt.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

    {{-- SCRIPT TAMBAH DI KEPADA --}}
    <script>
        let index = 1;

        function setupPegawaiSelectListener(select) {
            select.addEventListener('change', function () {
                const selected = this.options[this.selectedIndex];
                const nip = selected?.dataset?.nip || '';
                const row = this.closest('.kepada-row');
                if (row) {
                    const nipInput = row.querySelector('input[name*="[nip]"]');
                    if (nipInput) nipInput.value = nip;
                }
            });
        }

        function tambahKepada() {
            const container = document.getElementById('kepada-container');
            const row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'kepada-row', 'g-2', 'align-items-end');
            row.innerHTML = `
                <div class="col-md-3">
                    <select name="kepada[${index}][pegawai_id]" class="form-select pegawai-select" required>
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}" data-nip="{{ $pegawai->nip ?? $pegawai->niptt_pk }}">
                                {{ $pegawai->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="kepada[${index}][pangkat_gol]" class="form-select" required>
                        <option value="">-- Pilih Pangkat/Gol --</option>
                        @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->pangkat_gol }}">{{ $pegawai->pangkat_gol }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" name="kepada[${index}][nip]" class="form-control nip" placeholder="NIP / NIPTT-PK" readonly>
                </div>
                <div class="col-md-3">
                    <select name="kepada[${index}][jabatan]" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->jabatan }}">{{ $pegawai->jabatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-outline-danger" onclick="hapusKepada(this)">&times;</button>
                </div>
            `;
            container.appendChild(row);
            setupPegawaiSelectListener(row.querySelector('.pegawai-select'));
            index++;
            reindexKepada();
        }

        function hapusKepada(btn) {
            const row = btn.closest('.kepada-row');
            if (row) {
                row.remove();
                reindexKepada();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.pegawai-select').forEach(setupPegawaiSelectListener);
        });

        // === Dasar ===
        let nomorDasar = 2;

        function tambahDasar() {
            const container = document.getElementById('dasar-container');
            const row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'dasar-item', 'align-items-start');
            row.innerHTML = `
                <div class="col-auto pt-2 dasar-number">?</div>
                <div class="col">
                    <textarea name="dasar[]" class="form-control" placeholder="Isi dasar peraturan atau referensi" required></textarea>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-outline-danger" onclick="hapusDasar(this)">&times;</button>
                </div>
            `;
            container.appendChild(row);
            updateNomorDasar();
        }

        function hapusDasar(btn) {
            const item = btn.closest('.dasar-item');
            if (item) {
                item.remove();
                updateNomorDasar();
            }
        }

        function updateNomorDasar() {
            const items = document.querySelectorAll('#dasar-container .dasar-item');
            items.forEach((it, idx) => {
                const num = it.querySelector('.dasar-number');
                if (num) num.textContent = `${idx + 1}.`;
            });
        }
    </script>

@endsection

