@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Detail Pegawai</h3>
    <h5 class="my-4">{{ $pegawai->nama }}</h5>

    <hr>

    <div class="card-body card shadow-sm">
        <h4 class="my-4 text-center">Riwayat SPT</h4>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr class="table-primary">
                    <th>Nomor SPT</th>
                    <th>Tanggal</th>
                    <th>Untuk</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pegawai->sptLangsung as $spt)
                    <tr>
                        <td>{{ $spt->nomor_surat }}</td>
                        <td>{{ $spt->tanggal }}</td>
                        <td class="text-justify">{{ $spt->untuk }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada SPT</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
