<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - NginapKuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS untuk Admin Dashboard */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa; /* Latar belakang yang lebih terang */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .main-content {
            flex-grow: 1;
            padding: 30px 0;
        }
        .stat-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .stat-card h3 {
            font-size: 1.2rem;
            color: #6c757d;
        }
        .stat-card p {
            font-size: 2.5rem;
            font-weight: 700;
            color: #007bff;
        }
        .recent-bookings-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 20px;
        }
        .recent-bookings-section h4 {
            color: #343a40;
            margin-bottom: 20px;
        }
        footer {
            background-color: #343a40; /* Footer gelap untuk admin */
            color: white;
            padding: 20px 0;
            margin-top: auto;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }
        .table th {
            background-color: #e9ecef;
            color: #495057;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fs-4 fw-bold" href="{{ route('admin.dashboard') }}">Admin Panel - Halo, {{ Auth::user()->name }}!</a>
            <div class="ms-auto">
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container main-content">
        <h1 class="mb-4 text-center">Dashboard Admin</h1>

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

        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>Total Pengguna</h3>
                    <p class="text-primary">{{ $totalUsers }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>Total Kamar</h3>
                    <p class="text-info">{{ $totalRooms }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>Total Pemesanan</h3>
                    <p class="text-success">{{ $totalBookings }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>Pemesanan Pending</h3>
                    <p class="text-warning">{{ $pendingBookings }}</p>
                </div>
            </div>
        </div>

        <div class="recent-bookings-section mt-4">
            <h4 class="mb-3">Pemesanan Terbaru</h4>
            @if($latestBookings->isEmpty())
                <p class="text-muted text-center">Tidak ada pemesanan terbaru.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pengguna</th>
                                <th>Kamar No.</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestBookings as $booking)
                            <tr>
                                <td>{{ $booking->id_pemesanan }}</td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->kamar->nomor_kamar }} ({{ $booking->kamar->tipeKamar->nama_tipe_kamar }})</td>
                                <td>{{ $booking->check_in_date->format('d M Y') }}</td>
                                <td>{{ $booking->check_out_date->format('d M Y') }}</td>
                                <td>Rp {{ number_format($booking->total_harga, 2, ',', '.') }}</td>
                                <td><span class="badge {{ $booking->status_pemesanan == 'pending' ? 'bg-warning' : ($booking->status_pemesanan == 'confirmed' ? 'bg-success' : 'bg-secondary') }}">{{ $booking->status_pemesanan }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <footer class="text-center bg-dark text-white">
        <div class="container py-3">
            <p class="mb-0">&copy; {{ date('Y') }} Admin Panel - NginapKuy. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>