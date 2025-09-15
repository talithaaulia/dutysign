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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('pegawai.create') }}" class="btn btn-success my-2">+ Tambah Pegawai</a>

    <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file" class="form-label mt-3">Upload File Excel</label>
            <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls">
            <small class="text-muted">Jika data pegawai berbentuk Excel, upload dengan format Excel: Nama, Pangkat/Gol, NIP/NIPTT-PK, Jabatan</small>
        </div>
        <button class="btn btn-info mt-1 mb-4">Import Excel</button>
    </form>

    <form action="{{ route('pegawai.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama atau pangkat/gol...">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

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

                        <tr id="noData" style="display: none;">
                            <td colspan="5" class="text-center text-muted">Data tidak ditemukan</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        const tableRows = document.querySelectorAll('table tbody tr');
        const noDataRow = document.getElementById('noData');

        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            let visibleCount = 0;

            tableRows.forEach(row => {
                if (row.id === 'noData') return;

                const nama = row.cells[0].textContent.toLowerCase();
                const pangkat = row.cells[1].textContent.toLowerCase();

                if (nama.includes(filter) || pangkat.includes(filter)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // "Data tidak ditemukan" jika tidak ada
            noDataRow.style.display = visibleCount === 0 ? '' : 'none';
        });
    });
</script>
@endsection


