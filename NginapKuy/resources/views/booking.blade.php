<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kamar: {{ $kamar->nomor_kamar }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/booking.css') }}" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('dashboard') }}">NginapKuy</a>
            <div class="ms-auto">
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container main-content">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="booking-card">
                    <div class="card-header-booking">Pesan Kamar: {{ $kamar->nomor_kamar }}</div>
                    
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="text-center mb-4">
                            <img src="{{ asset($kamar->tipeKamar->foto_url) }}" class="room-image-detail" alt="Foto Kamar {{ $kamar->nomor_kamar }}">
                        </div>

                        <div class="room-details-section mb-4">
                            <h4>Detail Kamar</h4>
                            <p><strong>Nomor Kamar:</strong> {{ $kamar->nomor_kamar }}</p>
                            <p><strong>Tipe Kamar:</strong> {{ $kamar->tipeKamar->nama_tipe_kamar }}</p>
                            <p><strong>Harga Per Malam:</strong> Rp {{ number_format($kamar->tipeKamar->harga_per_malam, 2, ',', '.') }}</p>
                            <p><strong>Deskripsi Tipe:</strong> {{ $kamar->tipeKamar->deskripsi }}</p>
                            <p><strong>Status:</strong> {{ $kamar->status_kamar ? 'Tersedia' : 'Tidak Tersedia' }}</p>
                        </div>

                        <hr class="my-4">

                        <div class="booking-form-section">
                            <h4>Formulir Pemesanan</h4>
                            <form action="{{ route('booking.store') }}" method="POST">
                                @csrf

                                <input type="hidden" name="kamar_id" value="{{ $kamar->id_kamar }}">

                                <div class="mb-3">
                                    <label for="check_in_date" class="form-label">Tanggal Check-in</label>
                                    <input type="date" class="form-control" id="check_in_date" name="check_in_date" value="{{ old('check_in_date') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="check_out_date" class="form-label">Tanggal Check-out</label>
                                    <input type="date" class="form-control" id="check_out_date" name="check_out_date" value="{{ old('check_out_date') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah_tamu" class="form-label">Jumlah Tamu</label>
                                    <input type="number" class="form-control" id="jumlah_tamu" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" required>
                                </div>

                                {{-- Bagian untuk memilih fasilitas --}}
                                @if($fasilitasTersedia->isNotEmpty())
                                    <div class="mb-4">
                                        <label class="form-label">Pilih Fasilitas Tambahan:</label>
                                        @foreach ($fasilitasTersedia as $fasilitas)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fasilitas_ids[]" value="{{ $fasilitas->id_fasilitas }}" id="fasilitas_{{ $fasilitas->id_fasilitas }}"
                                                    {{ in_array($fasilitas->id_fasilitas, old('fasilitas_ids', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="fasilitas_{{ $fasilitas->id_fasilitas }}">
                                                    {{ $fasilitas->nama_fasilitas }} (Rp {{ number_format($fasilitas->biaya_tambahan, 2, ',', '.') }})
                                                    @if($fasilitas->deskripsi)
                                                        - {{ $fasilitas->deskripsi }}
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-submit-booking">Konfirmasi Pemesanan</button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-back-dashboard">Kembali ke Dashboard</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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