<?php
// routes/web.php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
// KARENA AdminController, DashboardController, BookingController ADA DI app/Http/Controllers/
use App\Http\Controllers\Admin\DashboardAdminController; // Pastikan ini diimport
use App\Http\Controllers\DashboardController; // Dashboard umum
use App\Http\Controllers\BookingController; // Untuk pemesanan
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\TipeKamarController;
use App\Http\Controllers\Admin\PemesananController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FasilitasController;

// KARENA LoginController dan RegisterController ADA DI app/Http/Controllers/Auth/
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


// --- Rute Umum (BISA DIAKSES TANPA LOGIN) ---
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// --- Rute Autentikasi (Login, Register, Logout) ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// --- Grup Rute yang MEMERLUKAN AUTENTIKASI (Login) ---
Route::middleware('auth')->group(function () {

    // Rute Pemesanan Kamar
    Route::get('/pesan-kamar/{kamar}', [BookingController::class, 'showBookingForm'])->name('booking.create');
    Route::post('/pesan-kamar', [BookingController::class, 'store'])->name('booking.store');
    Route::middleware(['auth', 'role'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
        Route::resource('kamars', KamarController::class);
        Route::resource('tipe_kamars', TipeKamarController::class);

        Route::resource('pemesanans', PemesananController::class);
        Route::patch('pemesanans/{pemesanan}/checkin', [PemesananController::class, 'checkIn'])->name('pemesanans.checkin');
        Route::patch('pemesanans/{pemesanan}/checkout', [PemesananController::class, 'checkout'])->name('pemesanans.checkout');
        Route::patch('pemesanans/{pemesanan}/confirm', [PemesananController::class, 'confirm'])->name('pemesanans.confirm');
        Route::get('pembayaran/{pemesanan}', [PembayaranController::class, 'show'])->name('pembayaran.show'); // PERUBAHAN NAMA RUTE
        Route::post('pembayaran/{pemesanan}/process', [PembayaranController::class, 'process'])->name('pembayaran.process'); // PERUBAHAN NAMA RUTE
        Route::get('riwayat-transaksi', [PembayaranController::class, 'history'])->name('riwayat.transaksi'); // <-- Rute baru
        Route::resource('users', UserController::class); // <-- Tambahkan baris ini
        Route::resource('fasilitas', FasilitasController::class);
        // Route::put('admin/fasilitas/{fasilitas}', [FasilitasController::class, 'update'])->name('admin.fasilitas.update');


    });
});
