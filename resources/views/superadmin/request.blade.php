@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Permintaan Approval SPT</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No. Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Kepada</th>
                        <th>Penandatangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($spts as $index => $spt)
                        <tr>
                            <td>{{ $spt->nomor_surat }}</td>
                            <td>{{ $spt->tanggal }}</td>
                            <td>
                            <ul class="mb-0 text-justify">
                                @foreach($spt->pegawais as $p)
                                    <li>{{ $p->pivot->nama }}
                                @endforeach
                            </ul>
                        </td>
                            <td>
                                <form action="{{ route('superadmin.request.setSigner', $spt->id) }}" method="POST">
                                    @csrf
                                    <select class="form-select form-select-sm" name="penandatangan" onchange="this.form.submit()">
                                        <option selected disabled>Pilih</option>
                                        <option value="kepala" {{ $spt->penandatangan == 'kepala' ? 'selected' : '' }}>Kepala</option>
                                        <option value="sekretaris" {{ $spt->penandatangan == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('spt.show', $spt->id) }}" class="btn btn-warning btn-sm">
                                        Preview
                                    </a>

                                    <form action="{{ route('spt.approve', $spt->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                    </form>

                                    <form action="{{ route('spt.reject', $spt->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted">Tidak ada permintaan approval</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection
