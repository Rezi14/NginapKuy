<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; // Ini sudah benar, diimpor

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // --- BAGIAN INI YANG PERLU DITAMBAHKAN/DIUBAH ---
        $middleware->alias([
            'admin' => AdminMiddleware::class, // Mendaftarkan alias 'admin'
            'role' => AdminMiddleware::class,  // Mendaftarkan alias 'role'
        ]);
        // --- AKHIR BAGIAN YANG PERLU DITAMBAHKAN/DIUBAH ---
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();