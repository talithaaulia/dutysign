@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Input Laporan Perjalanan Dinas</h3>

    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h5>Checklist Laporan</h5>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="checklist[]" value="foto_kegiatan" id="fotoKegiatan">
                    <label class="form-check-label fw-semibold" for="fotoKegiatan">Foto Kegiatan <span class="text-danger">*</span></label>
                    <br>
                    <p for="foto_kegiatan" class="form-label">Upload Foto Kegiatan</label>
                    <input type="file" name="foto_kegiatan" class="form-control" accept="image/*" required>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="checklist[]" value="scan_hardcopy" id="scanHardcopy">
                    <label class="form-check-label fw-semibold" for="scanHardcopy">Scan Hardcopy Laporan <span class="text-danger">*</span></label>
                    <br>
                    <label for="scan_hardcopy" class="form-label">Upload Scan Hardcopy Laporan</label>
                    <input type="file" name="scan_hardcopy" class="form-control" accept=".pdf,.jpg,.png" required>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="checklist[]" value="e_toll" id="eToll">
                    <label class="form-check-label fw-semibold" for="eToll">Biaya E-Toll (Jika Ada)</label>
                    <br>
                    <label for="e_toll" class="form-label">Upload Bukti Biaya E-Toll</label>
                    <input type="file" name="e_toll" class="form-control" accept=".pdf,.jpg,.png">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="checklist[]" value="bbm" id="bbm">
                    <label class="form-check-label fw-semibold" for="bbm">Biaya BBM (Jika Ada)</label>
                    <br>
                    <label for="bbm" class="form-label">Upload Bukti Biaya BBM</label>
                    <input type="file" name="bbm" class="form-control" accept=".pdf,.jpg,.png">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>

            </div>
        </div>
    </form>
</div>
@endsection
