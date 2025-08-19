@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Daftar Semua SPT</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No.</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Kepada</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th>Surat</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($spts as $index => $spt)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $spt->nomor_surat }}</td>
                            <td>{{ $spt->tanggal }}</td>
                            <td>
                                <ul class="mb-0 text-justify">
                                    @foreach ($spt->pegawais as $p)
                                        <li>{{ $p->pivot->nama }}
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                @if ($spt->status == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($spt->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('spt.show', $spt->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                                <a href="{{ route('spt.edit', $spt->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('spt.destroy', $spt->id) }}" method="POST"
                                    class="d-inline delete-confirm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                            <td>
                                -
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Belum ada data SPT</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
