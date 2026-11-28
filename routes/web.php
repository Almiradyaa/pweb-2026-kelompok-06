<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProfileController;

// Halaman Beranda / Landing Page (batabutu)
Route::get('/', function () {
    return view('landing');
})->name('home');

// Halaman Katalog & Detail Buku (Sisi Anggota / Pengunjung)
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

// Rute Profil & Peminjaman Pengguna Login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pinjam-detail', function () {
        return view('pinjam-detail');
    })->name('pinjam.detail');
});

// Rute Terproteksi Berdasarkan Peran (Dari main)
Route::middleware(['auth', 'verified'])->group(function () {

    // Khusus pustakawan
    Route::middleware('role:pustakawan')->prefix('admin')->name('admin.')->group(function () {
        // nanti: resource penulis, anggota, buku (#12, #13)
    });

    // Khusus anggota
    Route::middleware('role:anggota')->group(function () {
        // nanti: pengajuan peminjaman (#16)
    });
});

// Rute CRUD Buku khusus untuk Pustakawan
Route::middleware(['auth', 'role:pustakawan'])->group(function () {
    Route::resource('buku', BukuController::class);
});

// Rute Preview Sementara UI Frontend (Dari main)
Route::view('/preview-daftar-email', 'auth.register-email');
Route::view('/preview-daftar-sandi', 'auth.register-password');
Route::view('/preview-otp', 'auth.verify-otp');
Route::view('/preview-daftar-profil', 'auth.register-profile');
Route::view('/preview-login', 'auth.login');
Route::view('/preview-landing', 'landing');
Route::view('/preview-katalog', 'catalog');

Route::get('/preview-antre', function () {
    return view('pinjam-detail', ['status' => 'antre']);
});

Route::get('/preview-dipinjam', function () {
    return view('pinjam-detail', ['status' => 'dipinjam']);
});

require __DIR__.'/auth.php';