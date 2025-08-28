@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Pegawai</h3>

    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $pegawai->nama) }}" required>
        </div>

        <div class="mb-3">
            <label>Pangkat / Golongan</label>
            <input type="text" name="pangkat_gol" class="form-control" value="{{ old('pangkat_gol', $pegawai->pangkat_gol) }}">
        </div>

        <div class="mb-3">
            <label>NIP (jika PNS)</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip', $pegawai->nip) }}">
        </div>

        <div class="mb-3">
            <label>NIPTT-PK (jika Non-PNS)</label>
            <input type="text" name="niptt_pk" class="form-control" value="{{ old('niptt_pk', $pegawai->niptt_pk) }}">
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $pegawai->jabatan) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
