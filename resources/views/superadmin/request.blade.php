@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Permintaan Approval SPT</h4>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>No. Surat</th>
                <th>Tanggal Pengajuan</th>
                <th>Penandatangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>000.1.2.3/4461/107.1/2025</td>
                <td>2025-07-19</td>
                <td>
                    <form>
                        <select class="form-select form-select-sm" name="penandatangan">
                            <option selected disabled>Pilih</option>
                            <option value="kepala">Kepala Dinas</option>
                            <option value="sekretaris">Sekretaris Dinas</option>
                        </select>
                    </form>
                </td>
                <td>
                    <form class="d-flex gap-1 justify-content-center">
                        <button type="submit" class="btn btn-primary btn-sm">Preview</button>
                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
