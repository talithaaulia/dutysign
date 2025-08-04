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
                    <p class="card-text fs-4">10</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5 class="card-title">SPT Menunggu approval</h5>
                    <p class="card-text fs-4">6</p>
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
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama pegawai...">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>

                    @php
                        $search = strtolower(request('search'));
                        $dummyData = [
                            ['nama' => 'Ahmad Fauzi', 'jumlah' => 5],
                            ['nama' => 'Sri Lestari', 'jumlah' => 3],
                            ['nama' => 'Rina Wijaya', 'jumlah' => 7],
                        ];
                        $filteredData = array_filter($dummyData, function($item) use ($search) {
                            return $search === '' || str_contains(strtolower($item['nama']), $search);
                        });
                        $filteredData = array_values($filteredData); // reset index array agar bisa dipakai di loop
                    @endphp

                    {{-- Tabel hasil pencarian --}}
                    <table class="table table-bordered table-striped">
                        <thead class="table-secondary text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Jumlah Perjalanan Dinas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($filteredData as $i => $pegawai)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $pegawai['nama'] }}</td>
                                    <td class="text-center">{{ $pegawai['jumlah'] }} kali</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada data yang cocok</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
