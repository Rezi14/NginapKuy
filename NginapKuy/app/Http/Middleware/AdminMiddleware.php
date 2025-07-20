<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user login dan memiliki role 'admin'
        if (Auth::check() && Auth::user()->role && Auth::user()->role->nama_role === 'admin') {
            return $next($request); // Lanjutkan permintaan
        }

        // Jika bukan admin atau tidak login, redirect ke halaman utama atau halaman login
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        // Atau redirect ke halaman login jika Anda ingin:
        // return redirect()->route('login')->with('error', 'Silakan login sebagai admin untuk mengakses halaman ini.');
    }
}