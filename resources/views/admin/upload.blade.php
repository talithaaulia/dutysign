@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Upload Surat Scan (TTD & Stempel)</h3>

    {{-- Dummy alert sukses --}}
    {{-- <div class="alert alert-success">Surat berhasil diupload.</div> --}}

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="#" method="POST" enctype="multipart/form-data">
                {{-- CSRF hanya sebagai dummy --}}
                @csrf

                {{-- Pilih Surat --}}
                <div class="mb-3">
                    <label for="spt_id" class="form-label">Pilih Surat</label>
                    <select name="spt_id" id="spt_id" class="form-select" required>
                        <option value="">Pilih Nomor Surat</option>
                        <option value="1">000.1.2.3/4461/107.1/2025</option>
                        <option value="2">000.2.3.4/5562/108.2/2025</option>
                        <option value="3">000.4.5.6/7712/109.3/2025</option>
                    </select>
                </div>

                {{-- Upload File --}}
                <div class="mb-3">
                    <label for="file_scan" class="form-label">Upload File (PDF)</label>
                    <input type="file" name="file_scan" id="file_scan" class="form-control"
                        accept=".pdf,.jpg,.jpeg,.png" required>
                    <small class="text-muted">Maksimal ukuran file 1MB.</small>
                </div>

                <button type="submit" class="btn btn-primary">Upload Surat</button>
            </form>
        </div>
    </div>
</div>
@endsection
