<?php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin; // <<< PERHATIKAN NAMESPACE INI

use App\Http\Controllers\Controller; // Pastikan ini diimport
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kamar;
use App\Models\Pemesanan;

class DashboardController extends Controller
{
    // Terapkan AdminMiddleware ke controller ini
    public function __construct()
    {
        $this->middleware('admin'); // Memanggil middleware 'admin' yang sudah didaftarkan
    }

    public function index()
    {
        // Ambil data statistik untuk dashboard admin
        $totalUsers = User::count();
        $totalRooms = Kamar::count();
        $totalBookings = Pemesanan::count();
        $pendingBookings = Pemesanan::where('status_pemesanan', 'pending')->count();
        $confirmedBookings = Pemesanan::where('status_pemesanan', 'confirmed')->count();
        $latestBookings = Pemesanan::with(['user', 'kamar'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalRooms', 'totalBookings',
            'pendingBookings', 'confirmedBookings', 'latestBookings'
        ));
    }
}