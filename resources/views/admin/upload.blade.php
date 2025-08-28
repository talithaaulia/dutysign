@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Upload Surat Scan (TTD & Stempel)</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('spt.upload.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Pilih Surat --}}
                <div class="mb-3">
                    <label for="spt_id" class="form-label">Pilih Surat</label>
                    <select name="spt_id" id="spt_id" class="form-select" required>
                        <option value="">-- Pilih Surat --</option>
                        @foreach($spts as $spt)
                            <option value="{{ $spt->id }}">
                                {{ $spt->nomor_surat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Upload File --}}
                <div class="mb-3">
                    <label for="file_scan" class="form-label">Upload File</label>
                    <input type="file" name="file_scan" id="file_scan" class="form-control"
                        accept=".pdf,.jpg,.jpeg,.png" required>
                    <small class="text-muted">Maksimal ukuran file 1 MB</small>
                    <br>
                    <small id="fileError" class="text-danger" style="display: none;">
                        Ukuran file lebih dari 1 MB! Silakan pilih file lain
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">Upload Surat</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('file_scan').addEventListener('change', function () {
    let file = this.files[0];
    let errorMsg = document.getElementById('fileError');

    if (file && file.size > 1024 * 1024) {
        errorMsg.style.display = "inline";
        this.value = ""; // reset input
    } else {
        errorMsg.style.display = "none";
    }
});
</script>
@endsection
