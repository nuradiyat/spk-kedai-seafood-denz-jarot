<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\HasilSawController;
use App\Http\Controllers\RiwayatPenilaianController;

/*
🔓 ROUTE PUBLIK (LOGIN)
*/

// halaman login
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// proses login
Route::post('/login', function () {
    // nanti logic login
})->name('login.process');


/*
🔐 ROUTE AUTH (HARUS LOGIN)
*/

Route::middleware(['auth'])->group(function () {

    /*
    👤 ROLE ADMIN
    */
    Route::middleware(['role:admin'])->group(function () {

        // CRUD Karyawan
        Route::resource('karyawan', KaryawanController::class);

        // CRUD Kriteria (tanpa create & edit page)
        Route::resource('kriteria', KriteriaController::class)->except(['create', 'edit', 'show']);

        // Penilaian
        Route::resource('penilaian', PenilaianController::class)->only(['index', 'create', 'store']);

        // Proses SAW
        Route::get('/hasil/proses/{id}', [HasilSawController::class, 'proses'])->name('hasil.proses');
    });

    /*
    👑 ROLE OWNER
    */
    Route::middleware(['role:owner'])->group(function () {

        // Hasil SAW
        Route::get('/hasil', [HasilSawController::class, 'index'])->name('hasil.index');

        // Detail perhitungan (WAJIB ADA ID)
        Route::get('/hasil/detail/{id}', [HasilSawController::class, 'detail'])->name('hasil.detail');

        // Riwayat
        Route::get('/riwayat', [RiwayatPenilaianController::class, 'index'])->name('riwayat.index');
    });

    /*
    🔓 LOGOUT
    */
    Route::post('/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');
});
