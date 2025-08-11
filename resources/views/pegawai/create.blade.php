@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Pegawai</h3>

    <form action="{{ route('pegawai.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Pangkat / Golongan</label>
            <input type="text" name="pangkat_gol" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status Pegawai</label>
            <select name="status_pegawai" class="form-control" required>
                <option value="pns">-- Pilih --</option>
                <option value="pns">PNS</option>
                <option value="nonpns">Non-PNS</option>
            </select>
        </div>

        <div class="mb-3">
            <label>NIP (jika PNS)</label>
            <input type="text" name="nip" class="form-control">
        </div>

        <div class="mb-3">
            <label>NIPTT-PK (jika Non-PNS)</label>
            <input type="text" name="niptt_pk" class="form-control">
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
