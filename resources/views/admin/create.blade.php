@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Buat Surat Tugas</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('spt.store') }}" method="POST">
            @csrf

            {{-- NOMOR SURAT --}}
            <div class="mb-3">
                <label for="nomor_surat" class="form-label">Nomor Surat</label>
                <input type="text" name="nomor_surat" id="nomor_surat" class="form-control"
                    placeholder="Contoh: 000.1.2.3/4461/107.1/2025" required>
            </div>

            {{-- DASAR --}}
            <div class="mb-3">
                <label class="form-label">Dasar</label>
                <div id="dasar-container">
                    <div class="row mb-2 dasar-item align-items-start">
                        <div class="col-auto pt-2 dasar-number">1.</div>
                        <div class="col">
                            <textarea name="dasar[]" class="form-control" placeholder="Isi dasar peraturan atau referensi"
                                required></textarea>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-danger" onclick="hapusDasar(this)"
                                aria-label="Hapus Dasar">&times;</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="tambahDasar()">+ Tambah Dasar</button>
            </div>

            {{-- KEPADA (MULTI INPUT) --}}
            <div class="mb-3">
                <label class="form-label">Kepada (Pegawai yang Ditugaskan)</label>
                <div id="kepada-container">
                    <div class="row mb-2 kepada-row g-2 align-items-end">
                        <div class="col-md-3">
                                <select name="kepada[0][pegawai_id]" class="form-select pegawai-select" data-index="0"
                                    required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}" data-nip="{{ $pegawai->nip ?? $pegawai->niptt_pk }}">
                                            {{ $pegawai->nama }}
                                        </option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-3">
                            <select name="kepada[0][pangkat_gol]" class="form-select" required>
                                <option value="">-- Pilih Pangkat/Gol --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->pangkat_gol }}">
                                        {{ $pegawai->pangkat_gol }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="kepada[0][nip]" class="form-control nip" placeholder="NIP / NIPTT-PK"
                                readonly>
                        </div>
                        <div class="col-md-3">
                            <select name="kepada[0][jabatan]" class="form-select" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->jabatan }}">
                                        {{ $pegawai->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-danger" onclick="hapusKepada(this)"
                                aria-label="Hapus Kepada">&times;</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="tambahKepada()">+ Tambah
                    Pegawai</button>
            </div>

            {{-- UNTUK --}}
            <div class="mb-3">
                <label for="untuk" class="form-label">Untuk</label>
                <textarea name="untuk" id="untuk" rows="3" class="form-control"
                    placeholder="Isi keperluan atau tujuan surat tugas" required></textarea>
            </div>

            {{-- TEMPAT PENETAPAN --}}
            <div class="mb-3">
                <label for="untuk" class="form-label">Ditetapkan di</label>
                <input type="text" name="ditetapkan_di" id="ditetapkan_di" class="form-control" placeholder="Isi nama kota"
                    required>
            </div>

            {{-- TANGGAL PEMBUATAN --}}
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Pembuatan</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
            </div>

            {{-- SUBMIT --}}
            <button type="submit" class="btn btn-primary">Simpan Surat Tugas</button>
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
