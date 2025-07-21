<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kamar; // Contoh: untuk menampilkan data kamar
use App\Models\Pemesanan;
use App\Models\User; // Untuk menghitung total pengguna

class DashboardAdminController extends Controller
{
    public function index()
    {
        $totalKamar = Kamar::count();
        $totalPemesanan = Pemesanan::count(); // Asumsikan Anda punya model Pemesanan
        $totalPengguna = User::count(); // Atau User::where('id_role', 2)->count(); untuk hanya pelanggan

        return view('admin.dashboard', compact('totalKamar', 'totalPemesanan', 'totalPengguna'));
    }
}