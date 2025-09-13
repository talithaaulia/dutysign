@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Penandatangan</h4>

    <a href="{{ route('penandatangan.create') }}" class="btn btn-primary mb-3">Tambah Penandatangan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Pangkat/Gol</th>
                        <th>NIP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penandatangans as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->jabatan }}</td>
                            <td>{{ $p->pangkat_gol }}</td>
                            <td>{{ $p->nip }}</td>
                            <td>
                                <form action="{{ route('penandatangan.destroy', $p->id) }}" method="POST" class="d-inline delete-confirm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Belum ada penandatangan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
