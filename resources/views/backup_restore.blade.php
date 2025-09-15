@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Backup & Restore</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <label class="form-label">Backup Data</label>
    <br>
    <a href="{{ route('backup') }}" class="btn btn-success mb-4">Download Backup</a>

    <form action="{{ route('restore') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="backup_file">Upload File Backup (.zip)</label>
            <input type="file" name="backup_file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Restore</button>
    </form>
</div>
@endsection
