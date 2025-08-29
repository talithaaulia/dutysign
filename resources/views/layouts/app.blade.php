<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        {{ config('app.name') }}
    </title>
    <link rel="icon" href="{{ asset('images/logo-dinsos.png') }}" type="image/png">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            background-color: rgb(230, 230, 230)
        }
        .sidebar {
            width: 220px;
            background-color:	#2172ea;
            color: white;
        }
        .sidebar a {
            color: white;
            padding: 10px 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a.active {
            background-color: rgb(31, 88, 193);
            color: white;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #406182;
        }

        .main {
            flex: 1;
            padding: 20px;
        }

        .form-check-input {
            border-color: #0a58ca;
        }

        .text-justify {
            text-align: justify;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">DUTYSIGN</h4>
        <img src="{{ asset('images/logo-dinsos.png') }}" alt="Logo" class="img-fluid mx-auto d-block mb-3" style="width: 100px; height: 100px;">
        <p class="text-center text-light fw-bold">Halo {{ auth()->user()->role }}!</p>
        @if(auth()->user()->role == 'admin')
            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="/create" class="{{ request()->is('create') ? 'active' : '' }}">Buat SPT</a>
            <a href="/list" class="{{ request()->is('list') ? 'active' : '' }}">Lihat Semua SPT</a>
            <a href="/upload" class="{{ request()->is('upload') ? 'active' : '' }}">Upload Surat</a>
            <a href="/report" class="{{ request()->is('report') ? 'active' : '' }}">Input Laporan</a>
            <a href="/view" class="{{ request()->is('view') ? 'active' : '' }}">Lihat Laporan</a>
            <a href="/pegawai" class="{{ request()->is('pegawai') ? 'active' : '' }}">Data Pegawai</a>
        @elseif(auth()->user()->role == 'super_admin')
            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="/request" class="{{ request()->is('request') ? 'active' : '' }}">Permintaan Approval</a>
            <a href="/viewSpt" class="{{ request()->is('viewSpt') ? 'active' : '' }}">Lihat Semua SPT</a>
            <a href="/penandatangan" class="{{ request()->is('penandatangan') ? 'active' : '' }}">Penandatangan</a>
            <a href="/account" class="{{ request()->is('account') ? 'active' : '' }}">Buat Akun</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="text-center px-3 mt-3">
            @csrf
            <button type="submit" class="btn btn-link text-danger fw-bold p-0" style="text-decoration: none;">
                Logout
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert::alert')


    @yield('scripts')
    @include('sweetalert::alert')
    <script>
    document.querySelectorAll('.delete-confirm').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<script>
    document.querySelectorAll('.delete-confirm').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // 🔹 Buat konfirmasi untuk tombol Setujui/Tolak
    function confirmation(e, form, title, text) {
        e.preventDefault();
        Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjut!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>



</body>
</html>
