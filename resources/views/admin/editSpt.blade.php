@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Surat Perintah Tugas</h3>

    <form action="{{ route('spt.update', $spt->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat</label>
            <input type="text" name="nomor_surat" class="form-control" value="{{ old('nomor_surat', $spt->nomor_surat) }}">
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Surat</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $spt->tanggal) }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="menunggu" {{ $spt->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="disetujui" {{ $spt->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ $spt->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('spt.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
