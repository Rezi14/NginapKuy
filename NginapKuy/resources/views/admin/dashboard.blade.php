<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - NginapKuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    {{-- Anda bisa membuat CSS khusus admin jika diperlukan, misal: --}}
    {{-- <link href="{{ asset('css/admindashboard.css') }}" rel="stylesheet"> --}}
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f8f9fa; /* Warna latar belakang terang */
        }
        .navbar-brand {
            font-size: 1.8rem !important;
        }
        .sidebar {
            background-color: #343a40; /* Warna sidebar gelap */
            color: white;
            padding: 20px;
            min-height: calc(100vh - 56px); /* Tinggi sidebar dikurangi tinggi navbar */
            position: sticky;
            top: 0;
            left: 0;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            color: white;
            background-color: #495057;
        }
        .sidebar .nav-link.active {
            color: white;
            background-color: #007bff; /* Warna aktif primer */
            border-radius: 5px;
        }
        .main-content {
            flex-grow: 1;
            padding: 30px;
        }
        .card-admin-stats {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .card-admin-stats:hover {
            transform: translateY(-5px);
        }
        .card-admin-stats .card-body h3 {
            color: #007bff;
        }
        .card-admin-stats .card-body p {
            font-size: 2.5rem;
            font-weight: bold;
            color: #343a40;
        }
        footer {
            background-color: #e9ecef;
            padding: 20px 0;
            color: #6c757d;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fs-4 fw-bold" href="{{ route('admin.dashboard') }}">Admin Panel - NginapKuy</a>
            <div class="ms-auto">
                @if (Auth::check()) {{-- Menggunakan Auth::check() untuk kepastian --}}
                    <form action="{{ route('logout') }}" method="POST" class="d-flex">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                @endif
            </div>
        </div>
    </nav>

    <div class="container-fluid flex-grow-1 d-flex">
        {{-- Sidebar Navigasi Admin --}}
        <div class="sidebar">
            <h5 class="text-white mb-4">Navigasi Admin</h5>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    {{-- Anda perlu membuat rute dan kontroler untuk ini, misal: admin.kamars.index --}}
                    <a class="nav-link" href="#">
                        <i class="fas fa-bed me-2"></i> Manajemen Kamar
                    </a>
                </li>
                <li class="nav-item">
                    {{-- Anda perlu membuat rute dan kontroler untuk ini, misal: admin.pemesanan.index --}}
                    <a class="nav-link" href="#">
                        <i class="fas fa-receipt me-2"></i> Manajemen Pemesanan
                    </a>
                </li>
                <li class="nav-item">
                    {{-- Anda perlu membuat rute dan kontroler untuk ini, misal: admin.users.index --}}
                    <a class="nav-link" href="#">
                        <i class="fas fa-users me-2"></i> Manajemen Pengguna
                    </a>
                </li>
            </ul>
        </div>

        {{-- Konten Utama Dashboard Admin --}}
        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card p-4 mb-4 text-center bg-info text-white">
                <div class="card-body">
                    <h2 class="card-title fs-3 fw-bold mb-3">Selamat Datang, Admin {{ Auth::user()->name }}!</h2>
                    <p class="card-text fs-5">Panel Kontrol Administrasi Hotel NginapKuy.</p>
                </div>
            </div>

            {{-- Bagian Statistik Admin --}}
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-admin-stats text-center p-3">
                        <div class="card-body">
                            <h3>Total Kamar</h3>
                            {{-- Asumsikan DashboardAdminController mengirimkan data ini --}}
                            <p>{{ $totalKamar ?? 'N/A' }}</p> 
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-admin-stats text-center p-3">
                        <div class="card-body">
                            <h3>Total Pemesanan</h3>
                            {{-- Asumsikan DashboardAdminController mengirimkan data ini --}}
                            <p>{{ $totalPemesanan ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-admin-stats text-center p-3">
                        <div class="card-body">
                            <h3>Total Pengguna</h3>
                            {{-- Asumsikan DashboardAdminController mengirimkan data ini --}}
                            <p>{{ $totalPengguna ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Anda bisa menambahkan bagian lain di sini, misal: --}}
            {{-- - Tabel pemesanan terbaru
            - Grafik statistik
            - Link cepat ke tindakan admin lainnya --}}

        </div>
    </div>

    <footer>
        <div class="container py-3">
            <p class="mb-0">&copy; {{ date('Y') }} NginapKuy Admin. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    {{-- Font Awesome untuk ikon (opsional) --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>