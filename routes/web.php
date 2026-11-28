<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

// Halaman Beranda / Landing Page (batabutu)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard sesuai peran setelah login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute CRUD Buku khusus untuk Pustakawan
Route::middleware(['auth', 'role:pustakawan'])->group(function () {
    Route::resource('buku', BukuController::class);
});

require __DIR__.'/auth.php';