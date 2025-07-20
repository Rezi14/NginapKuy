<?php

namespace App\Http\Controllers;

// UBAH BARIS INI:
use Illuminate\Routing\Controller; // Meng-extend langsung kelas Controller dari framework Laravel

use Illuminate\Http\Request;
use App\Models\Kamar; // Import model Kamar
use App\Models\Pemesanan; // Import model Pemesanan
use Illuminate\Support\Facades\Auth; // Import untuk mendapatkan user yang sedang login

class BookingController extends Controller // Pastikan tetap extends Controller
{
    // Tambahkan middleware 'auth' agar hanya user yang login bisa mengakses ini
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan formulir pemesanan untuk kamar tertentu.
     * Menggunakan Route Model Binding untuk Kamar.
     *
     * @param  \App\Models\Kamar  $kamar
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showBookingForm(Kamar $kamar)
    {
        // Pastikan relasi tipeKamar dimuat
        $kamar->load('tipeKamar');

        // Mengirim objek kamar ke view
        return view('booking', compact('kamar'));
    }

    /**
     * Memproses dan menyimpan data pemesanan kamar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi Data Input
        $request->validate([
            'kamar_id' => 'required|exists:kamars,id_kamar',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'jumlah_tamu' => 'required|integer|min:1',
        ]);

        // 2. Ambil informasi kamar yang dipesan
        $kamar = Kamar::findOrFail($request->kamar_id);
        $kamar->load('tipeKamar');

        // 3. Hitung Durasi Menginap
        $checkIn = \Carbon\Carbon::parse($request->check_in_date);
        $checkOut = \Carbon\Carbon::parse($request->check_out_date);
        $durasiMenginap = $checkIn->diffInDays($checkOut);
        if ($durasiMenginap == 0) {
            $durasiMenginap = 1;
        }

        // 4. Hitung Total Harga
        $hargaPerMalam = $kamar->tipeKamar->harga_per_malam;
        $totalHarga = $hargaPerMalam * $durasiMenginap;

        // 5. Buat Entri Pemesanan Baru
        Pemesanan::create([
            'user_id' => Auth::id(),
            'kamar_id' => $kamar->id_kamar,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'jumlah_tamu' => $request->jumlah_tamu,
            'total_harga' => $totalHarga,
            'status_pemesanan' => 'pending',
        ]);

        // 6. Redirect atau Berikan Respon
        return redirect()->route('dashboard')->with('success', 'Pemesanan kamar berhasil dibuat! Total harga: Rp ' . number_format($totalHarga, 2, ',', '.'));
    }
}