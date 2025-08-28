@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Pegawai</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('pegawai.create') }}" class="btn btn-success my-2">+ Tambah Pegawai</a>

    <div class="card shadow-sm">
        <div class="card-body">
    <table class="table table-bordered">
        <thead>
            <tr class="table table-secondary" style="text-align: center;">
                <th>Nama</th>
                <th>Pangkat/Gol</th>
                <th>NIP / NIPTT-PK</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawais as $pegawai)
                <tr>
                    <td>{{ $pegawai->nama }}</td>
                    <td>{{ $pegawai->pangkat_gol }}</td>
                    <td>{{ $pegawai->nip ?? $pegawai->niptt_pk }}</td>
                    <td>{{ $pegawai->jabatan }}</td>
                    <td>
                        <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-warning btn-sm">Edit Data</a>
                        <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline delete-confirm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
@endsection
