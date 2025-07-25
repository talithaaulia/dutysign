@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Buat Akun Admin</h4>

    <form action="#" method="POST">
        {{-- @csrf --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" placeholder="Nama Admin">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Admin</label>
            <input type="email" class="form-control" id="email" placeholder="email@example.com">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" class="form-control" id="password" placeholder="********">
        </div>
        <button type="submit" class="btn btn-success">Simpan Akun</button>
    </form>
</div>
@endsection
