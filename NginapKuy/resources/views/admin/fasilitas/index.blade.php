<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Fasilitas - NginapKuy Admin</title>
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

        {{-- Konten Utama Manajemen Fasilitas --}}
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Manajemen Fasilitas</h2>
                <a href="{{ route('admin.fasilitas.create') }}" class="btn btn-primary">Tambah Fasilitas Baru</a>
            </div>

            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    @if ($fasilitas->isEmpty())
                        <p class="text-center">Tidak ada fasilitas yang terdaftar.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Fasilitas</th>
                                        <th>Deskripsi</th>
                                        <th>Biaya Tambahan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fasilitas as $item)
                                        <tr>
                                            <td>{{ $item->id_fasilitas }}</td>
                                            <td>{{ $item->nama_fasilitas }}</td>
                                            <td>{{ $item->deskripsi ?? '-' }}</td>
                                            <td>Rp {{ number_format($item->biaya_tambahan, 2, ',', '.') }}</td>
                                            <td>
                                                {{-- PERBAIKAN: Secara eksplisit meneruskan parameter 'fasilitas' --}}
                                                <a href="{{ route('admin.fasilitas.edit', $item->id_fasilitas) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.fasilitas.destroy', $item->id_fasilitas) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
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