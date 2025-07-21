<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tipe Kamar Baru - NginapKuy Admin</title>
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
                    <a class="nav-link {{ request()->routeIs('admin.pemesanans.*') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.pemesanans.index') }}">
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

        {{-- Konten Utama Tambah Tipe Kamar --}}
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Tambah Tipe Kamar Baru</h2>
                <a href="{{ route('admin.tipe_kamars.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Tipe Kamar
                </a>
            </div>

            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.tipe_kamars.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_tipe_kamar" class="form-label">Nama Tipe Kamar</label>
                            <input type="text" class="form-control" id="nama_tipe_kamar" name="nama_tipe_kamar" value="{{ old('nama_tipe_kamar') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_per_malam" class="form-label">Harga Per Malam</label>
                            <input type="number" step="0.01" class="form-control" id="harga_per_malam" name="harga_per_malam" value="{{ old('harga_per_malam') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="foto_url" class="form-label">URL Foto (misal: /img/standard.jpg)</label>
                            <input type="text" class="form-control" id="foto_url" name="foto_url" value="{{ old('foto_url') }}">
                            <div class="form-text">Masukkan path relatif ke foto tipe kamar.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Tipe Kamar</button>
                    </form>
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