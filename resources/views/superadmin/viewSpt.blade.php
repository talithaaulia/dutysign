{{-- resources/views/admin/list.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Semua SPT</h4>

        <div class="card shadow-sm">
        <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal</th>
                    <th>Kepada</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse($spts as $index => $spt)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $spt->nomor_surat }}</td>
                        {{-- <td>{{ \Carbon\Carbon::parse($spt->tanggal)->format('d-m-Y') }}</td> --}}
                        <td>{{ $spt->tanggal }}</td>
                        <td>
                            <ul class="mb-0 text-justify">
                                @foreach($spt->pegawais as $p)
                                    <li>{{ $p->pivot->nama }}
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if($spt->status == 'menunggu')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($spt->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('spt.show', $spt->id) }}" class="btn btn-sm btn-warning">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada data SPT</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
    </div>
</div>
@endsection
