<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kamar; // Import model Kamar

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data kamar yang status_kamar-nya true (tersedia)
        // Dengan eager loading untuk relasi tipeKamar agar tidak terjadi N+1 query problem
        $kamarsTersedia = Kamar::with('tipeKamar')
                                ->where('status_kamar', true) // Filter kamar yang statusnya true
                                ->get();

        // Mengirim data kamar yang tersedia ke view dashboard
        return view('dashboard', [
            'kamarsTersedia' => $kamarsTersedia,
            'user' => Auth::user() // Mengirim data user ke view juga
        ]);
    }
}