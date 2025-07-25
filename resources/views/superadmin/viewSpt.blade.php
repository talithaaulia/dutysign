@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Semua SPT</h4>

    <div class="mb-3">
        <a href="#" class="btn btn-primary">Export PDF</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No.</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Kepada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td>1</td>
                    <td>000.1.2.3/4461/107.1/2025</td>
                    <td>2025-06-05</td>
                    <td>
                        <ul class="mb-0 text-justify">
                            <li>Andi Wijaya - Kasubbag Umum</li>
                            <li>Sri Hidayati - Staf Kepegawaian</li>
                        </ul>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Lihat Detail</a>
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>000.2.3.4/5562/108.2/2025</td>
                    <td>2025-07-08</td>
                    <td>
                        <ul class="mb-0 text-justify">
                            <li>Wijaya Andi - Kasubbag Umum</li>
                            <li>Hidayati Sri - Staf Kepegawaian</li>
                        </ul>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Lihat Detail</a>
                    </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>000.4.5.6/7712/109.3/2025</td>
                    <td>2025-07-08</td>
                    <td>
                        <ul class="mb-0 text-justify">
                            <li>Andi Wijaya - Kasubbag Umum</li>
                            <li>Sri Hidayati - Staf Kepegawaian</li>
                        </ul>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Lihat Detail</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

