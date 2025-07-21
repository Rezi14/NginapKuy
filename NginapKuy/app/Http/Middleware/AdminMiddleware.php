<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Gunakan method hasRole() yang lebih deskriptif
            if (Auth::user()->hasRole('admin')) { // Memeriksa apakah pengguna memiliki peran 'admin'
                return $next($request);
            }
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses admin.'); // Atau halaman login
    }
}