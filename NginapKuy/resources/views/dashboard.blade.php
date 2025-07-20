<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - NginapKuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/dashboardpengguna.css') }}" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid px-4">
            <a class="navbar-brand fs-4 fw-bold" href="#">Halo, {{ $user ? $user->name : 'Pengunjung' }}!</a>
            <div class="ms-auto">
                @if ($user)
                    <form action="{{ route('logout') }}" method="POST" class="d-flex">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-success">Register</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container my-5 flex-grow-1">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card p-4 mb-4 text-center">
            <div class="card-body">
                <h2 class="card-title text-primary fs-3 fw-bold mb-3">Selamat Datang di Dasbor Anda!</h2>
                <p class="card-text text-muted fs-5">Temukan kamar yang tersedia dan kelola pengalaman pemesanan Anda dengan mudah.</p>
            </div>
        </div>

        <div class="card p-4">
            <h2 class="section-title text-center mb-4">Pilihan Kamar Tersedia</h2>

            @if ($kamarsTersedia->isEmpty())
                <p class="text-center text-muted fs-5 py-4">Maaf, saat ini tidak ada kamar yang tersedia untuk ditampilkan.</p>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($kamarsTersedia as $kamar)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset($kamar->tipeKamar->foto_url) }}" class="card-img-top room-image" alt="Kamar {{ $kamar->nomor_kamar }}">
                                
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title text-primary mb-3">Kamar Nomor: {{ $kamar->nomor_kamar }}</h3>
                                    <p class="card-text mb-2"><strong>Tipe Kamar:</strong> {{ $kamar->tipeKamar->nama_tipe_kamar }}</p>
                                    <p class="card-text mb-3 text-muted">{{ $kamar->tipeKamar->deskripsi }}</p>
                                    
                                    <div class="room-price-info mt-auto">
                                        <strong>Harga/Malam:</strong> Rp {{ number_format($kamar->tipeKamar->harga_per_malam, 2, ',', '.') }}
                                    </div>
                                    
                                    <div class="mt-3 text-center">
                                        {{-- Cek apakah pengguna sudah login sebelum menampilkan tombol pesan --}}
                                        @if ($user)
                                            <a href="{{ route('booking.create', ['kamar' => $kamar->id_kamar]) }}" class="btn btn-success w-100">Pesan Sekarang</a>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary w-100">Login untuk Memesan</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <footer class="text-center text-muted">
        <div class="container py-3">
            <p class="mb-0">&copy; {{ date('Y') }} NginapKuy. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>