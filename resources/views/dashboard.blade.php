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
                    <h5 class="card-title">Pegawai Dinas</h5>
                    <p class="card-text fs-4">7</p>
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

    <div class="row">
        <div class="col-md-6">
            <h5>Daftar Surat Terbaru</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between">
                    <span>No. Surat: 000.1.2.3/4461/107.1/2025</span>
                    <span class="badge bg-warning">Menunggu</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>No. Surat: 000.2.3.4/5562/108.2/2025</span>
                    <span class="badge bg-success">Disetujui</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>No. Surat: 000.4.5.6/7712/109.3/2025</span>
                    <span class="badge bg-danger">Ditolak</span>
                </li>
            </ul>
        </div>

        <div class="col-md-6">
            <h5>Statistik Perjalanan Dinas Bulan Ini</h5>
            <div class="progress mb-2">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 60%">Luar Kota: 60%</div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-secondary" role="progressbar" style="width: 10%">Dibatalkan: 10%</div>
            </div>
        </div>
    </div>
@endsection
