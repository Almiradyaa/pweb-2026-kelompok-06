<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

// ... rute lainnya ...

// Rute CRUD Buku khusus untuk Pustakawan
Route::middleware(['auth', 'role:pustakawan'])->group(function () {
    Route::resource('buku', BukuController::class);
});