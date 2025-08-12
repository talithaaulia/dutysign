@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Detail Surat Perintah Tugas</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Nomor Surat:</strong> {{ $spt->nomor_surat }}</p>
            <p><strong>Tanggal Surat:</strong> {{ $spt->tanggal }}</p>

            <p><strong>Kepada:</strong></p>
            <ul>
                @foreach($spt->pegawais as $p)
                    <li>{{ $p->pivot->nama }}</li>
                @endforeach
            </ul>

            <p><strong>Status:</strong>
                @if($spt->status == 'menunggu')
                    <span class="badge bg-warning">Menunggu</span>
                @elseif($spt->status == 'disetujui')
                    <span class="badge bg-success">Disetujui</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </p>

            <div class="mt-3">
                <a href="{{ route('spt.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
