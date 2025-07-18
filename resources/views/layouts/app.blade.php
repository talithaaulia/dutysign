<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        {{ config('app.name') }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            background-color: rgb(230, 230, 230)
        }
        .sidebar {
            width: 220px;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
            padding: 10px 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">DUTYSIGN</h4>
        <p class="text-center text-light fw-semibold">Halo {{ auth()->user()->role }}!</p>
        @if(auth()->user()->role == 'admin')
            <a href="/dashboard">Dashboard</a>
            <a href="/create">Buat SPT</a>
            <a href="/list">List SPT</a>
            <a href="/upload">Upload Surat</a>
            <a href="/report">Input Laporan</a>
            <a href="/view">Lihat Laporan</a>
        @elseif(auth()->user()->role == 'super_admin')
            <a href="/dashboard">Dashboard</a>
            <a href="/request">Permintaan Approval</a>
            <a href="/view">Lihat Semua SPT</a>
            <a href="/account">Kelola Akun</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="text-center px-3 mt-3">
            @csrf
            <button type="submit" class="btn btn-link text-danger p-0" style="text-decoration: none;">
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
</body>
</html>
