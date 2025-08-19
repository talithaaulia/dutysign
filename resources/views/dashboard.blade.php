@extends('layouts.app')

@section('content')
    <h4 class="mb-4">Dashboard</h4>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title">SPT Disetujui</h5>
                    <p class="card-text fs-4">12</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">Sudah TTD + Stempel</h5>
                    <p class="card-text fs-4">{{ $countSudahTTD }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5 class="card-title">SPT Menunggu approval</h5>
                    <p class="card-text fs-4">{{ $countMenunggu }}</p>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="row mt-5">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3 text-center">Rekap Perjalanan Dinas Pegawai</h5>

                    <form method="GET" action="{{ route('dashboard') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Cari nama pegawai...">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>

                    <table class="table table-bordered table-striped">
                        <thead class="table-secondary text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Jumlah Perjalanan Dinas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pegawais as $i => $pegawai)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $pegawai->nama }}</td>
                                    <td class="text-center">{{ $pegawai->spts_count }} kali</td>
                                    <td class="text-center">
                                        <a href="{{ route('dashboard.detail', $pegawai->id) }}" class="btn btn-sm btn-warning">Lihat Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
