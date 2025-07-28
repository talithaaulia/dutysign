@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Detail Surat Perintah Tugas</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Nomor Surat:</strong> 000.1.2.3/4461/107.1/2025</p>
            <p><strong>Tanggal Surat:</strong> 2025-06-05</p>
            <p><strong>Kepada:</strong></p>
            <ul>
                <li>Andi Wijaya - Kasubbag Umum</li>
                <li>Sri Hidayati - Staf Kepegawaian</li>
            </ul>
            <p><strong>Status:</strong> <span class="badge bg-success">Disetujui</span></p>

            <div class="mt-3">
                <a href="#" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
