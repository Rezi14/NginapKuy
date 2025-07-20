<?php

// routes/web.php
use Illuminate\Support\Facades\Route;

// KARENA BookingController dan DashboardController ADA DI app/Http/Controllers/
use App\Http\Controllers\DashboardController; // Dashboard umum
use App\Http\Controllers\BookingController; // Untuk pemesanan

// KARENA LoginController dan RegisterController ADA DI app/Http/Controllers/Auth/
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Karena Admin/DashboardController ada di subfolder Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;


// Rute Halaman Utama (Welcome Page)
// Route::get('/', function () {
//     return view('welcome');
// });

// Rute Dashboard Umum (BISA DIAKSES TANPA LOGIN)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


// Rute Autentikasi (Login, Register, Logout)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Grup Rute yang MEMERLUKAN AUTENTIKASI (untuk pelanggan yang ingin memesan dan admin)
Route::middleware('auth')->group(function () {

    // Rute Pemesanan Kamar (MEMERLUKAN LOGIN)
    Route::get('/pesan-kamar/{kamar}', [BookingController::class, 'showBookingForm'])->name('booking.create');
    Route::post('/pesan-kamar', [BookingController::class, 'store'])->name('booking.store');

    // Grup rute khusus ADMIN (MEMERLUKAN LOGIN DAN ROLE ADMIN)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Rute Dashboard Admin
        Route::get('/dashboardamin', [AdminDashboardController::class, 'index'])->name('dashboard');
        // Tambahkan rute manajemen admin lainnya di sini jika diperlukan
    });
});