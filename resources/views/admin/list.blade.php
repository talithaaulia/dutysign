@extends('layouts.app') {{-- Sesuaikan dengan layout utama kamu --}}

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Surat Tugas</h3>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel Surat Tugas --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No.</th>
                    <th>Nomor Surat</th>
                    <th>Dasar</th>
                    <th>Tanggal Surat</th>
                    <th>Untuk</th>
                    <th>Kepada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>000.1.2.3/4461/107.1/2025</td>
                    <td>Peraturan Gubernur ...</td>
                    <td>2025-06-05</td>
                    <td>Menghadiri Undangan ...</td>
                    <td>
                        <ul class="mb-0">
                            <li>Lorem Ipsum - Kasubbag Umum</li>
                            <li>Lorem Ipsum - Staf Kepegawaian</li>
                        </ul>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Lihat</a>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>000.2.3.4/5562/108.2/2025</td>
                    <td>Peraturan Gubernur ...</td>
                    <td>2025-07-08</td>
                    <td>Menghadiri Undangan ...</td>
                    <td>
                        <ul class="mb-0">
                            <li>Lorem Ipsum - Kasubbag Umum</li>
                            <li>Lorem Ipsum - Staf Kepegawaian</li>
                        </ul>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Lihat</a>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>000.4.5.6/7712/109.3/2025</td>
                    <td>Peraturan Gubernur ...</td>
                    <td>2025-07-08</td>
                    <td>Menghadiri Undangan ...</td>
                    <td>
                        <ul class="mb-0">
                            <li>Lorem Ipsum - Kasubbag Umum</li>
                            <li>Lorem Ipsum - Staf Kepegawaian</li>
                        </ul>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Lihat</a>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
