@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Input Laporan Perjalanan Dinas</h3>

    <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h5>Data SPT</h5>
                <div class="mb-3">
                    <label for="spt_id" class="form-label">Pilih SPT</label>
                    <select name="spt_id" id="spt_id" class="form-select" required>
                        <option value="">-- Pilih SPT --</option>
                        @foreach (\App\Models\Spt::with('pegawais')->get() as $spt)
                            <option value="{{  $spt->id }}">
                                {{ $spt->nomor_surat }} - {{ $spt->tanggal }}
                                (@foreach ($spt->pegawais as $pegawai) {{ $pegawai->nama }} @endforeach)
                            </option>
                        @endforeach
                    </select>
                </div>

                <h5>Checklist Laporan</h5>

                <div class="form-check mb-4">
                    <label class="form-check-label fw-semibold" for="fotoKegiatan">Foto Kegiatan <span class="text-danger">*</span></label>
                    <br>
                    <p for="foto_kegiatan" class="form-label">Upload Foto Kegiatan</label>
                    <input type="file" name="foto_kegiatan" class="form-control" accept="image/*" required>
                </div>

                <div class="form-check mb-4">
                    <label class="form-check-label fw-semibold" for="scanHardcopy">Scan Hardcopy Laporan <span class="text-danger">*</span></label>
                    <br>
                    <label for="scan_hardcopy" class="form-label">Upload Scan Hardcopy Laporan</label>
                    <input type="file" name="scan_hardcopy" class="form-control" accept=".pdf,.jpg,.png" required>
                </div>

                <div class="form-check mb-4">
                    <label class="form-check-label fw-semibold" for="eToll">Biaya E-Toll (Jika Ada)</label>
                    <br>
                    <label for="e_toll" class="form-label">Upload Bukti Biaya E-Toll</label>
                    <input type="file" name="e_toll" class="form-control" accept=".pdf,.jpg,.png">
                </div>

                <div class="form-check mb-3">
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
