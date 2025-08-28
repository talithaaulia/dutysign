@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Daftar Semua SPT</h3>

        <div class="mb-3">
            <a href="{{ route('spt.downloadAll') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-pdf"></i> Download Semua PDF
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
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
                                <tr
                            @if($spt->status == 'ditolak')
                                style="border-left: 6px solid red; background-color:#ffecec;"
                            @endif
                                >
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
                                        @if($spt->status == 'disetujui')
                                            <button type="button" class="btn btn-warning btn-sm previewBtn" data-id="{{ $spt->id }}">
                                                Preview
                                            </button>
                                        @else
                                            -
                                        @endif
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
