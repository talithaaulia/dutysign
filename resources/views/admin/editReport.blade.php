@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Edit Laporan Perjalanan Dinas</h3>

    <form action="{{ route('report.update', $report->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h5>Checklist Laporan</h5>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="checklist[]" value="foto_kegiatan" id="fotoKegiatan"
                        {{ $report->foto_kegiatan ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="fotoKegiatan">Foto Kegiatan <span class="text-danger">*</span></label>
                    @if($report->foto_kegiatan)
                        <p>File saat ini: <a href="{{ asset('storage/'.$report->foto_kegiatan) }}" target="_blank">Lihat</a></p>
                    @endif
                    <input type="file" name="foto_kegiatan" class="form-control" accept="image/*">
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="checklist[]" value="scan_hardcopy" id="scanHardcopy"
                        {{ $report->scan_hardcopy ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="scanHardcopy">Scan Hardcopy Laporan <span class="text-danger">*</span></label>
                    @if($report->scan_hardcopy)
                        <p>File saat ini: <a href="{{ asset('storage/'.$report->scan_hardcopy) }}" target="_blank">Lihat</a></p>
                    @endif
                    <input type="file" name="scan_hardcopy" class="form-control" accept=".pdf,.jpg,.png">
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="checklist[]" value="e_toll" id="eToll"
                        {{ $report->e_toll ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="eToll">Biaya E-Toll (Jika Ada)</label>
                    @if($report->e_toll)
                        <p>File saat ini: <a href="{{ asset('storage/'.$report->e_toll) }}" target="_blank">Lihat</a></p>
                    @endif
                    <input type="file" name="e_toll" class="form-control" accept=".pdf,.jpg,.png">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="checklist[]" value="bbm" id="bbm"
                        {{ $report->bbm ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="bbm">Biaya BBM (Jika Ada)</label>
                    @if($report->bbm)
                        <p>File saat ini: <a href="{{ asset('storage/'.$report->bbm) }}" target="_blank">Lihat</a></p>
                    @endif
                    <input type="file" name="bbm" class="form-control" accept=".pdf,.jpg,.png">
                </div>

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('report.index') }}" class="btn btn-secondary">Kembali</a>

            </div>
        </div>
    </form>
</div>
@endsection
