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
                                    <select class="form-select form-select-sm" name="penandatangan_id" onchange="this.form.submit()">
                                        <option value="" disabled {{ is_null($spt->penandatangan_id) ? 'selected' : '' }}>Pilih</option>
                                        @foreach($penandatangans as $pen)
                                            <option value="{{ $pen->id }}" {{ $spt->penandatangan_id == $pen->id ? 'selected' : '' }}>
                                                {{ $pen->jabatan }} - {{ $pen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button"
                                            class="btn btn-warning btn-sm previewBtn"
                                            data-id="{{ $spt->id }}">
                                        Preview
                                    </button>

                                    <form action="{{ route('spt.approve', $spt->id) }}" method="POST" style="display:inline;"
                                        onsubmit="confirmation(event, this, 'Setujui SPT?', 'SPT ini akan disetujui.')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                    </form>

                                    <form action="{{ route('spt.reject', $spt->id) }}" method="POST" style="display:inline;"
                                        onsubmit="confirmation(event, this, 'Tolak SPT?', 'SPT ini akan ditolak.')">
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
    <!-- Modal Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Surat Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="previewContent">
                    <div class="text-center text-muted">Pilih SPT untuk melihat preview...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.previewBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            let sptId = this.getAttribute('data-id');
            let url = `/superadmin/spt/${sptId}/preview`;

            // tampilkan modal
            let modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();

            // loading indicator
            document.getElementById('previewContent').innerHTML = "<div class='text-center text-muted'>Loading...</div>";

            // fetch data surat
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('previewContent').innerHTML = html;
                })
                .catch(err => {
                    document.getElementById('previewContent').innerHTML = "<div class='text-danger'>Gagal memuat preview</div>";
                });
        });
    });
});
</script>
@endsection
