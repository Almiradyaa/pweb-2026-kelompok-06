<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProfileController;

// Halaman Beranda / Landing Page (batabutu)
Route::get('/', function () {
    return view('landing');
})->name('home');

// Halaman Katalog & Detail Buku
Route::get('/katalog', function () {
    return view('catalog');
})->name('katalog');

Route::get('/detail-buku', function () {
    return view('detail-buku');
})->name('buku.detail.view');

// Dashboard sesuai peran setelah login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute Kelola Profil & Peminjaman Pengguna Login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/pinjam-detail', function () {
        return view('pinjam-detail');
    })->name('pinjam.detail');
});

// Rute CRUD Buku khusus untuk Pustakawan
Route::middleware(['auth', 'role:pustakawan'])->group(function () {
    Route::resource('buku', BukuController::class);
});

require __DIR__.'/auth.php';