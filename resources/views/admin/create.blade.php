@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Buat Surat Tugas</h2>

    <form action="{{ route('spt.store') }}" method="POST">
        @csrf

        {{-- NOMOR SURAT --}}
        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat</label>
            <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" placeholder="Contoh: 000.1.2.3/4461/107.1/2025" required>
        </div>

        {{-- DASAR --}}
        <div class="mb-3">
            <label for="dasar" class="form-label">Dasar</label>
            <textarea name="dasar" id="dasar" rows="4" class="form-control" placeholder="Isi dasar peraturan atau referensi" required></textarea>
        </div>

        {{-- KEPADA (MULTI INPUT) --}}
        <div class="mb-3">
            <label class="form-label">Kepada (Pegawai yang Ditugaskan)</label>
            <div id="kepada-container">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <input type="text" name="kepada[0][nama]" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="kepada[0][nip]" class="form-control" placeholder="NIP" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="kepada[0][jabatan]" class="form-control" placeholder="Jabatan" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="kepada[0][golongan]" class="form-control" placeholder="Golongan" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-secondary" onclick="tambahKepada()">+ Tambah Baris</button>
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

        {{-- TANDA TANGAN --}}
        @if(auth()->user()->role === 'superadmin')
        <div class="mb-3">
            <label for="penandatangan" class="form-label">Pejabat Penandatangan</label>
            <select name="penandatangan" id="penandatangan" class="form-select" required>
                <option value="">-- Pilih Penandatangan --</option>
                <option value="kadis">Kepala Dinas</option>
                <option value="sekdis">Sekretaris Dinas</option>
                {{-- Tambah jika perlu --}}
            </select>
        </div>
        @endif

        {{-- SUBMIT --}}
        <button type="submit" class="btn btn-primary">Simpan Surat Tugas</button>
    </form>
</div>

{{-- SCRIPT UNTUK TAMBAH KEPADA --}}
<script>
let index = 1;
function tambahKepada() {
    const container = document.getElementById('kepada-container');
    const row = document.createElement('div');
    row.classList.add('row', 'mb-2');
    row.innerHTML = `
        <div class="col-md-4">
            <input type="text" name="kepada[${index}][nama]" class="form-control" placeholder="Nama Lengkap" required>
        </div>
        <div class="col-md-2">
            <input type="text" name="kepada[${index}][nip]" class="form-control" placeholder="NIP" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="kepada[${index}][jabatan]" class="form-control" placeholder="Jabatan" required>
        </div>
        <div class="col-md-2">
            <input type="text" name="kepada[${index}][golongan]" class="form-control" placeholder="Golongan" required>
        </div>
    `;
    container.appendChild(row);
    index++;
}
</script>
@endsection
