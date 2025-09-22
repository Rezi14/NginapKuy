<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemesanan - NginapKuy Admin</title>
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

        {{-- Konten Utama Tambah Pemesanan --}}
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Tambah Pemesanan Baru</h2>
                <a href="{{ route('admin.pemesanans.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pemesanan
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

                    <form action="{{ route('admin.pemesanans.store') }}" method="POST" id="pemesananForm">
                        @csrf

                        <div class="form-group mb-3">
                            <label>Pilih Pelanggan atau Buat Baru</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" id="existingCustomer" value="existing" checked>
                                <label class="form-check-label" for="existingCustomer">Pilih Pelanggan Existing</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" id="newCustomer" value="new">
                                <label class="form-check-label" for="newCustomer">Buat Pelanggan Baru</label>
                            </div>
                        </div>

                        <div id="existingCustomerSection" class="mb-3">
                            <div class="form-group">
                                <label for="user_id">Pilih Pelanggan</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">Pilih Pengguna</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="newCustomerSection" class="mb-3" style="display: none;">
                            <div class="form-group mb-3">
                                <label for="new_user_name">Nama Pelanggan Baru</label>
                                <input type="text" name="new_user_name" id="new_user_name" class="form-control" value="{{ old('new_user_name') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="new_user_email">Email Pelanggan Baru</label>
                                <input type="email" name="new_user_email" id="new_user_email" class="form-control" value="{{ old('new_user_email') }}">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kamar_id">Kamar</label>
                            <select name="kamar_id" id="kamar_id" class="form-control" required>
                                <option value="">Pilih Kamar</option>
                                @foreach ($kamars as $kamar)
                                    <option value="{{ $kamar->id_kamar }}"
                                            data-harga-per-malam="{{ $kamar->tipeKamar->harga_per_malam }}"
                                            {{ old('kamar_id') == $kamar->id_kamar ? 'selected' : '' }}>
                                        Kamar No. {{ $kamar->nomor_kamar }} (Tipe: {{ $kamar->tipeKamar->nama_tipe_kamar ?? 'N/A' }}) - Rp {{ number_format($kamar->tipeKamar->harga_per_malam ?? 0, 0, ',', '.') }} / malam
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="check_in_date">Tanggal Check-in</label>
                            <input type="date" name="check_in_date" id="check_in_date" class="form-control" value="{{ old('check_in_date') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="check_out_date">Tanggal Check-out</label>
                            <input type="date" name="check_out_date" id="check_out_date" class="form-control" value="{{ old('check_out_date') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jumlah_tamu">Jumlah Tamu</label>
                            <input type="number" name="jumlah_tamu" id="jumlah_tamu" class="form-control" value="{{ old('jumlah_tamu') }}" required min="1">
                        </div>
                        <div class="form-group mb-3">
                            <label for="total_harga">Total Harga</label>
                            <input type="number" name="total_harga" id="total_harga" class="form-control" step="0.01" value="{{ old('total_harga') ?? 0 }}" required readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status_pemesanan">Status Pemesanan</label>
                            <select name="status_pemesanan" id="status_pemesanan" class="form-control" required>
                                <option value="pending" {{ old('status_pemesanan') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status_pemesanan') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="checked_in" {{ old('status_pemesanan') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                                <option value="checked_out" {{ old('status_pemesanan') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                                <option value="cancelled" {{ old('status_pemesanan') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Fasilitas Tambahan</label><br>
                            @foreach ($fasilitas as $item)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="fasilitas_tambahan[]" id="fasilitas_{{ $item->id_fasilitas }}" value="{{ $item->id_fasilitas }}"
                                           data-biaya-tambahan="{{ $item->biaya_tambahan }}"
                                         {{ in_array($item->id_fasilitas, old('fasilitas_tambahan', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="fasilitas_{{ $item->id_fasilitas }}">{{ $item->nama_fasilitas }} (Rp {{ number_format($item->biaya_tambahan, 0, ',', '.') }})</label>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Pemesanan</button>
                        <a href="{{ route('admin.pemesanans.index') }}" class="btn btn-secondary">Batal</a>
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

    {{-- Script JavaScript untuk Perhitungan Otomatis dan Toggle Pelanggan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kamarSelect = document.getElementById('kamar_id');
            const checkInDateInput = document.getElementById('check_in_date');
            const checkOutDateInput = document.getElementById('check_out_date');
            const fasilitasCheckboxes = document.querySelectorAll('input[name="fasilitas_tambahan[]"]');
            const totalHargaInput = document.getElementById('total_harga');

            const customerTypeRadios = document.querySelectorAll('input[name="customer_type"]');
            const existingCustomerSection = document.getElementById('existingCustomerSection');
            const newCustomerSection = document.getElementById('newCustomerSection');
            const userIdSelect = document.getElementById('user_id');
            const newUserNameInput = document.getElementById('new_user_name');
            const newUserEmailInput = document.getElementById('new_user_email');

            function toggleCustomerFields() {
                if (document.getElementById('existingCustomer').checked) {
                    existingCustomerSection.style.display = 'block';
                    newCustomerSection.style.display = 'none';
                    userIdSelect.setAttribute('required', 'required');
                    newUserNameInput.removeAttribute('required');
                    newUserEmailInput.removeAttribute('required');
                } else {
                    existingCustomerSection.style.display = 'none';
                    newCustomerSection.style.display = 'block';
                    userIdSelect.removeAttribute('required');
                    newUserNameInput.setAttribute('required', 'required');
                    newUserEmailInput.setAttribute('required', 'required');
                }
                userIdSelect.value = '';
                newUserNameInput.value = '';
                newUserEmailInput.value = '';
            }

            customerTypeRadios.forEach(radio => {
                radio.addEventListener('change', toggleCustomerFields);
            });

            function calculateTotalPrice() {
                let totalHarga = 0;

                const selectedKamarOption = kamarSelect.options[kamarSelect.selectedIndex];
                const hargaPerMalam = parseFloat(selectedKamarOption.dataset.hargaPerMalam || 0);

                const checkInDate = new Date(checkInDateInput.value);
                const checkOutDate = new Date(checkOutDateInput.value);

                if (checkInDate && checkOutDate && checkOutDate > checkInDate) {
                    const diffTime = Math.abs(checkOutDate - checkInDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    totalHarga += hargaPerMalam * diffDays;
                }

                fasilitasCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        totalHarga += parseFloat(checkbox.dataset.biayaTambahan || 0);
                    }
                });

                totalHargaInput.value = totalHarga.toFixed(2);
            }

            kamarSelect.addEventListener('change', calculateTotalPrice);
            checkInDateInput.addEventListener('change', calculateTotalPrice);
            checkOutDateInput.addEventListener('change', calculateTotalPrice);
            fasilitasCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotalPrice);
            });

            toggleCustomerFields();
            calculateTotalPrice();
        });
    </script>
</body>
</html>
