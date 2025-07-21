<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - NginapKuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admindashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel - NginapKuy</a>
            <div class="ms-auto">
                @if (Auth::check())
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
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.kamars.*') ? 'active' : '' }}" href="{{ route('admin.kamars.index') }}">
                        <i class="fas fa-bed me-2"></i> Manajemen Kamar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.tipe_kamars.*') ? 'active' : '' }}" href="{{ route('admin.tipe_kamars.index') }}">
                        <i class="fas fa-hotel me-2"></i> Manajemen Tipe Kamar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.pemesanans.*') ? 'active' : '' }}" href="{{ route('admin.pemesanans.index') }}">
                        <i class="fas fa-receipt me-2"></i> Manajemen Pemesanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users me-2"></i> Manajemen Pengguna
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}" href="{{ route('admin.fasilitas.index') }}">
                        <i class="fas fa-spa me-2"></i> Manajemen Fasilitas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.riwayat.transaksi') ? 'active' : '' }}" href="{{ route('admin.riwayat.transaksi') }}">
                        <i class="fas fa-history me-2"></i> Riwayat Transaksi
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

            <div class="card p-4 mb-4 card-welcome">
                <div class="card-body">
                    <h2 class="card-title mb-3">Selamat Datang, Admin {{ Auth::user()->name }}!</h2>
                    <p class="card-text fs-5">Panel Kontrol Administrasi Hotel NginapKuy.</p>
                </div>
            </div>

            {{-- Bagian Statistik Admin --}}
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card card-admin-stats">
                        <div class="card-body">
                            <h3>Total Kamar</h3>
                            <p>{{ $totalKamar ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-admin-stats">
                        <div class="card-body">
                            <h3>Total Pemesanan</h3>
                            <p>{{ $totalPemesanan ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-admin-stats">
                        <div class="card-body">
                            <h3>Total Pengguna</h3>
                            <p>{{ $totalPengguna ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Pelanggan Sedang Menginap --}}
            <div class="card p-4 shadow-sm">
                <div class="card-header bg-primary text-white text-center fs-5 fw-bold">
                    Pelanggan Sedang Menginap
                </div>
                <div class="card-body">
                    @if ($pelangganCheckin->isEmpty())
                        <p class="text-center">Tidak ada pelanggan yang sedang menginap saat ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Pemesanan</th>
                                        <th>Pelanggan</th>
                                        <th>Kamar</th>
                                        <th>Tipe Kamar</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Fasilitas Tambahan</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelangganCheckin as $pemesanan)
                                        <tr>
                                            <td>{{ $pemesanan->id_pemesanan }}</td>
                                            <td>{{ $pemesanan->user->name }}</td>
                                            <td>{{ $pemesanan->kamar->nomor_kamar }}</td>
                                            <td>{{ $pemesanan->kamar->tipeKamar->nama_tipe_kamar }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pemesanan->check_in_date)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pemesanan->check_out_date)->format('d M Y') }}</td>
                                            <td>
                                                @if ($pemesanan->fasilitas->isNotEmpty())
                                                    <ul>
                                                        @foreach ($pemesanan->fasilitas as $fasilitas)
                                                            <li>{{ $fasilitas->nama_fasilitas }} (Rp {{ number_format($fasilitas->biaya_tambahan, 2, ',', '.') }})</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    Tidak Ada
                                                @endif
                                            </td>
                                            <td>Rp {{ number_format($pemesanan->total_harga, 2, ',', '.') }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    {{-- Tombol Tambah Fasilitas (mengarah ke halaman edit) --}}
                                                    <a href="{{ route('admin.pemesanans.edit', $pemesanan->id_pemesanan) }}" class="btn btn-sm btn-info" title="Edit Pemesanan (Tambah Fasilitas)">
                                                        <i class="fas fa-plus"></i> Fasilitas
                                                    </a>
                                                    {{-- Tombol Checkout Pelanggan --}}
                                                    <form action="{{ route('admin.pemesanans.checkout', $pemesanan->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melakukan checkout pemesanan ini?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success" title="Checkout Pelanggan">
                                                            <i class="fas fa-check"></i> Checkout
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <footer>
        <div class="container py-3">
            <p class="mb-0">&copy; {{ date('Y') }} NginapKuy Admin. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>