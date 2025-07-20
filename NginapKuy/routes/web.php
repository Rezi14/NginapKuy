<?php
// routes/web.php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
// KARENA AdminController, DashboardController, BookingController ADA DI app/Http/Controllers/
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\DashboardController; // Dashboard umum
use App\Http\Controllers\BookingController; // Untuk pemesanan

// KARENA LoginController dan RegisterController ADA DI app/Http/Controllers/Auth/
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


// --- Rute Umum (BISA DIAKSES TANPA LOGIN) ---
Route::get('/', [DashboardController::class, 'index'])->name('home');
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

    // >>> Rute Dashboard Admin (TANPA PREFIX /ADMIN/) <<<
    // URL: /dashboardadmin
    // Nama Rute: dashboardadmin
    // Middleware 'admin' akan memastikan hanya user dengan role 'admin' yang bisa mengakses
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Rute Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard'); // Menggunakan alias
        // Tambahkan rute manajemen admin lainnya di sini jika diperlukan
        // Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    });
});