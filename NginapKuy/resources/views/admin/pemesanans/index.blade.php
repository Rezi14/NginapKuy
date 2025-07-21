<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pemesanan - NginapKuy Admin</title>
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

        {{-- Konten Utama Manajemen Pemesanan --}}
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
                <h2 class="mb-0">Manajemen Pemesanan</h2>
                {{-- Tombol Tambah Pemesanan Baru (opsional, jika admin bisa membuat pemesanan manual) --}}
                <a href="{{ route('admin.pemesanans.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Pemesanan Baru
                </a>
            </div>

            <div class="card p-4 shadow-sm">
                <div class="card-body">
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
                                    <th>Status</th>
                                    <th>Total Harga</th>
                                    <th>Fasilitas Tambahan</th>
                                    <th style="width: 120px;">Aksi</th> {{-- Lebar tetap untuk aksi --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pemesanans as $pemesanan)
                                    <tr>
                                        <td>{{ $pemesanan->id_pemesanan }}</td>
                                        <td>{{ $pemesanan->user->name ?? 'N/A' }}</td>
                                        <td>{{ $pemesanan->kamar->nomor_kamar ?? 'N/A' }}</td>
                                        <td>{{ $pemesanan->kamar->tipeKamar->nama_tipe_kamar ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pemesanan->check_in_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pemesanan->check_out_date)->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge {{ $pemesanan->status == 'pending' ? 'bg-warning text-dark' : ($pemesanan->status == 'confirmed' ? 'bg-success' : ($pemesanan->status == 'checked_in' ? 'bg-primary' : ($pemesanan->status == 'checked_out' ? 'bg-info' : 'bg-secondary'))) }}">
                                                {{ ucfirst(str_replace('_', ' ', $pemesanan->status)) }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($pemesanan->total_harga, 2, ',', '.') }}</td>
                                        <td>
                                            @if ($pemesanan->fasilitas->isNotEmpty())
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($pemesanan->fasilitas as $fasilitas)
                                                        <li>- {{ $fasilitas->nama_fasilitas }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                Tidak Ada
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-grid gap-1"> {{-- Untuk tombol aksi yang simetris --}}
                                                <a href="{{ route('admin.pemesanans.show', $pemesanan->id_pemesanan) }}" class="btn btn-sm btn-info w-100" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                {{-- <a href="{{ route('admin.pemesanans.edit', $pemesanan->id_pemesanan) }}" class="btn btn-sm btn-warning w-100" title="Edit Pemesanan">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a> --}}
                                                {{-- Tambahkan kelas 'w-100' pada form agar lebarnya konsisten --}}
                                                {{-- <form action="{{ route('admin.pemesanans.destroy', $pemesanan->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?');" class="w-100">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger w-100" title="Hapus Pemesanan">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada pemesanan yang tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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