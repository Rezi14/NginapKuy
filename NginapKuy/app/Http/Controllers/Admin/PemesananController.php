<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan; // Import model Pemesanan
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    /**
     * Menampilkan daftar semua pemesanan.
     */
    public function index()
    {
        // Ambil semua pemesanan, urutkan berdasarkan tanggal check-in terbaru,
        // dan preload relasi user, kamar, dan tipeKamar untuk menghindari N+1 query.
        $pemesanans = Pemesanan::with(['user', 'kamar.tipeKamar', 'fasilitas'])
                               ->orderBy('check_in_date', 'desc')
                               ->get();

        return view('admin.pemesanans.index', compact('pemesanans'));
    }

    /**
     * Menampilkan detail pemesanan tertentu.
     * Anda bisa mengembangkan ini nanti untuk melihat detail lebih lanjut,
     * mengubah status, dll.
     */
    public function show(Pemesanan $pemesanan)
    {
        // Load relasi jika belum dimuat
        $pemesanan->load(['user', 'kamar.tipeKamar', 'fasilitas']);
        return view('admin.pemesanans.show', compact('pemesanan'));
    }

    // Anda bisa menambahkan method lain seperti 'edit', 'update', 'destroy' di sini
    // jika Anda ingin admin bisa mengedit atau menghapus pemesanan.
    // Untuk saat ini, kita fokus pada tampilan daftar.
}