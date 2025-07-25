@extends('layouts.app')

@section('content')
    <h4 class="mb-4">Dashboard</h4>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">SPT Disetujui</h5>
                    <p class="card-text fs-4">12</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title">Sudah TTD + Stempel</h5>
                    <p class="card-text fs-4">10</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Dinas 2025</h5>
                    <p class="card-text fs-4">60</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <h5 class="card-title">Dinas Hari Ini</h5>
                    <p class="card-text fs-4">3</p>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="text-center mb-4">Statistik Perjalanan Dinas Tahun 2025</h5>
                    <canvas id="chartTahunan" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3 text-center">Rekap Perjalanan Dinas Pegawai - {{ date('Y') }}</h5>

                    <form method="GET" action="{{ route('dashboard') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama pegawai...">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>

                    {{-- Filter data dummy --}}
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

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartTahunan').getContext('2d');
        const chartTahunan = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Dinas (%)',
                    data: [15, 22, 35, 40, 25, 10, 60, 50, 30, 28, 20, 38],
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        title: {
                            display: true,
                            text: 'Persentase Dinas (%)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + '% dari total perjalanan dinas';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
