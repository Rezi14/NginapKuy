<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan - NginapKuy Admin</title>
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

        {{-- Konten Utama Detail Pemesanan --}}
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
                <h2 class="mb-0">Detail Pemesanan #{{ $pemesanan->id_pemesanan }}</h2>
                <a href="{{ route('admin.pemesanans.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pemesanan
                </a>
            </div>

            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Pelanggan:</strong></div>
                        <div class="col-md-8">{{ $pemesanan->user->name ?? 'N/A' }} ({{ $pemesanan->user->email ?? 'N/A' }})</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Kamar:</strong></div>
                        <div class="col-md-8">{{ $pemesanan->kamar->nomor_kamar ?? 'N/A' }} (Tipe: {{ $pemesanan->kamar->tipeKamar->nama_tipe_kamar ?? 'N/A' }})</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Check-in:</strong></div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($pemesanan->check_in_date)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Check-out:</strong></div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($pemesanan->check_out_date)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Jumlah Tamu:</strong></div>
                        <div class="col-md-8">{{ $pemesanan->jumlah_tamu }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Status Pemesanan:</strong></div>
                        <div class="col-md-8">
                            <span class="badge {{ $pemesanan->status_pemesanan == 'pending' ? 'bg-warning text-dark' : ($pemesanan->status_pemesanan == 'confirmed' ? 'bg-success' : ($pemesanan->status_pemesanan == 'checked_in' ? 'bg-primary' : ($pemesanan->status_pemesanan == 'checked_out' ? 'bg-info' : ($pemesanan->status_pemesanan == 'paid' ? 'bg-dark' : 'bg-secondary')))) }}">
                                {{ ucfirst(str_replace('_', ' ', $pemesanan->status_pemesanan)) }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Total Harga:</strong></div>
                        <div class="col-md-8">Rp {{ number_format($pemesanan->total_harga, 2, ',', '.') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Pemesanan:</strong></div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->format('d F Y H:i:s') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Fasilitas Tambahan:</strong></div>
                        <div class="col-md-8">
                            @if ($pemesanan->fasilitas->isNotEmpty())
                                <ul class="list-unstyled mb-0">
                                    @foreach ($pemesanan->fasilitas as $fasilitas)
                                        <li>- {{ $fasilitas->nama_fasilitas }} (Rp {{ number_format($fasilitas->biaya_tambahan, 2, ',', '.') }})</li>
                                    @endforeach
                                </ul>
                            @else
                                Tidak Ada
                            @endif
                        </div>
                    </div>

                    <hr>

                    {{-- Bagian untuk Aksi Admin --}}
                    <h5>Aksi Admin</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        {{-- Tombol Konfirmasi Pemesanan --}}
                        @if($pemesanan->status_pemesanan === 'pending')
                            <form action="{{ route('admin.pemesanans.confirm', $pemesanan->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengkonfirmasi pemesanan ini?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Terima Pesanan</button>
                            </form>
                        @else
                            <button type="button" class="btn btn-secondary" disabled><i class="fas fa-check-circle me-1"></i> Terima Pesanan</button>
                        @endif

                        {{-- Tombol Check-in --}}
                        @if($pemesanan->status_pemesanan === 'confirmed')
                            <form action="{{ route('admin.pemesanans.checkin', $pemesanan->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melakukan check-in pemesanan ini?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt me-1"></i> Check-in</button>
                            </form>
                        @else
                             <button type="button" class="btn btn-secondary" disabled><i class="fas fa-sign-in-alt me-1"></i> Check-in</button>
                        @endif
                        
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.pemesanans.edit', $pemesanan->id_pemesanan) }}" class="btn btn-warning"><i class="fas fa-edit me-1"></i> Edit Detail</a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.pemesanans.destroy', $pemesanan->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt me-1"></i> Hapus Pemesanan</button>
                        </form>
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