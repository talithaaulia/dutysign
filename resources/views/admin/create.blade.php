@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Buat Surat Tugas</h2>

    <form action="{{ route('spt.store') }}" method="POST">
        @csrf

        {{-- NOMOR SURAT  --}}
        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat</label>
            <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" placeholder="Contoh: 000.1.2.3/4461/107.1/2025" required>
        </div>

        {{-- DASAR --}}
        <div class="mb-3">
            <label class="form-label">Dasar</label>
            <div id="dasar-container">
                <div class="row mb-2 dasar-item align-items-start">
                    <div class="col-auto pt-2 dasar-number">1.</div>
                    <div class="col">
                        <textarea name="dasar[]" class="form-control" placeholder="Isi dasar peraturan atau referensi" required></textarea>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-danger" onclick="hapusKepada(this)" aria-label="Hapus Kepada">&times;</button>
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
                    <div class="col-md-4">
                        <select name="kepada[0][pegawai_id]" class="form-select pegawai-select" data-index="0" required>
                            <option value="">-- Pilih Pegawai --</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="kepada[0][nip]" class="form-control nip" placeholder="NIP" readonly>
                    </div>
                    <div class="col-md-3">
                        <select name="kepada[0][jabatan]" class="form-select" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Staff">Staff</option>
                            <option value="Kasi">Kasi</option>
                            <option value="Kabid">Kabid</option>
                            <option value="Sekdis">Sekretaris Dinas</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                      <select name="kepada[0][golongan]" class="form-select" required>
                            <option value="">-- Pilih Golongan --</option>
                            <option value="II/a">II/a</option>
                            <option value="III/a">III/a</option>
                            <option value="III/b">III/b</option>
                            <option value="IV/a">IV/a</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-danger" onclick="hapusKepada(this)" aria-label="Hapus Kepada">&times;</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="tambahKepada()">+ Tambah Pegawai</button>
        </div>

        {{-- UNTUK --}}
        <div class="mb-3">
            <label for="untuk" class="form-label">Untuk</label>
            <textarea name="untuk" id="untuk" rows="3" class="form-control" placeholder="Isi keperluan atau tujuan surat tugas" required></textarea>
        </div>

        {{-- TEMPAT PENETAPAN --}}
        <div class="mb-3">
            <label for="untuk" class="form-label">Ditetapkan di</label>
            <input name="untuk" id="untuk" rows="3" class="form-control" placeholder="Isi nama kota" required></input>
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

    // DUMMY
    const pegawaiData = [
        { id: 1, nama: 'Andi Wijaya', nip: '1987654321' },
        { id: 2, nama: 'Siti Marlina', nip: '1990123456' },
        { id: 3, nama: 'Budi Santoso', nip: '1988123411' },
    ];

    function loadPegawaiDropdown(select, idx) {
        select.innerHTML = '<option value="">-- Pilih Pegawai --</option>';
        pegawaiData.forEach(p => {
            const option = document.createElement('option');
            option.value = p.id;
            option.textContent = p.nama;
            option.dataset.nip = p.nip;
            select.appendChild(option);
        });

        // listener ubah NIP
        select.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const nip = selected?.dataset?.nip || '';
            const row = this.closest('.kepada-row');
            if (row) {
                const nipInput = row.querySelector('input[name^="kepada"][name$="[nip]"]');
                if (nipInput) nipInput.value = nip;
            }
        });
    }

    function tambahKepada() {
        const container = document.getElementById('kepada-container');
        const row = document.createElement('div');
        row.classList.add('row', 'mb-2', 'kepada-row', 'g-2', 'align-items-end');
        row.innerHTML = `
            <div class="col-md-4">
                <select name="kepada[${index}][pegawai_id]" class="form-select pegawai-select" data-index="${index}" required>
                    <option value="">-- Pilih Pegawai --</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="kepada[${index}][nip]" class="form-control nip" placeholder="NIP" readonly>
            </div>
            <div class="col-md-3">
                <select name="kepada[${index}][jabatan]" class="form-select" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="Staff">Staff</option>
                    <option value="Kasi">Kasi</option>
                    <option value="Kabid">Kabid</option>
                    <option value="Sekdis">Sekretaris Dinas</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="kepada[${index}][golongan]" class="form-select" required>
                    <option value="">-- Pilih Golongan --</option>
                    <option value="II/a">II/a</option>
                    <option value="III/a">III/a</option>
                    <option value="III/b">III/b</option>
                    <option value="IV/a">IV/a</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-outline-danger" onclick="hapusKepada(this)">&times;</button>
            </div>
        `;
        container.appendChild(row);

        const newSelect = row.querySelector('.pegawai-select');
        loadPegawaiDropdown(newSelect, index);
        index++;
        reindexKepada(); // pastikan nama berurutan
    }

    function hapusKepada(btn) {
        const row = btn.closest('.kepada-row');
        if (row) {
            row.remove();
            reindexKepada();
        }
    }

    function reindexKepada() {
        const rows = document.querySelectorAll('#kepada-container .kepada-row');
        rows.forEach((row, i) => {
            // update semua name attribute berdasarkan urutan baru
            const pegawaiSelect = row.querySelector('.pegawai-select');
            const jabatan = row.querySelector('select[name*="[jabatan]"]');
            const golongan = row.querySelector('select[name*="[golongan]"]');
            const nipInput = row.querySelector('input[name*="[nip]"]');

            if (pegawaiSelect) {
                pegawaiSelect.name = `kepada[${i}][pegawai_id]`;
                pegawaiSelect.dataset.index = i;
            }
            if (nipInput) nipInput.name = `kepada[${i}][nip]`;
            if (jabatan) jabatan.name = `kepada[${i}][jabatan]`;
            if (golongan) golongan.name = `kepada[${i}][golongan]`;
        });
    }

    // Inisialisasi pertama kali
    document.addEventListener('DOMContentLoaded', () => {
        // load dasar tidak perlu apa-apa karena statis
        const select = document.querySelector('.pegawai-select');
        if (select) loadPegawaiDropdown(select, 0);
    });

    // SCRIPT TAMBAH DI DASAR
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
