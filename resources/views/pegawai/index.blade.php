@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Pegawai</h3>
    <a href="{{ route('pegawai.create') }}" class="btn btn-success mb-3">+ Tambah Pegawai</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Pangkat/Gol</th>
                <th>Status</th>
                <th>NIP / NIPTT-PK</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawais as $pegawai)
                <tr>
                    <td>{{ $pegawai->nama }}</td>
                    <td>{{ $pegawai->pangkat_gol }}</td>
                    <td>{{ $pegawai->status_pegawai }}</td>
                    <td>{{ $pegawai->nip ?? $pegawai->niptt_pk }}</td>
                    <td>{{ $pegawai->jabatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
