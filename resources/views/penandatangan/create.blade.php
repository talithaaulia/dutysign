@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Penandatangan</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('penandatangan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <select name="jabatan" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <option value="Kepala">Kepala</option>
                        <option value="Sekretaris">Sekretaris</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pangkat/Gol</label>
                    <input type="text" name="pangkat_gol" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('penandatangan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
