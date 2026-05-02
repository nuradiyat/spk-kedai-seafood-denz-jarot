<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\HasilSawController;
use App\Http\Controllers\RiwayatPenilaianController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| 🔓 ROUTE PUBLIK (LOGIN)
|--------------------------------------------------------------------------
*/

// halaman login
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// proses login (nanti kamu buat controllernya)
Route::post('/login', function () {
    // logic login nanti
})->name('login.process');

/*
|--------------------------------------------------------------------------
| 🔐 ROUTE AUTH (HARUS LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 👤 ROLE ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {

        // 📌 CRUD Karyawan
        Route::resource('karyawan', KaryawanController::class);

        // 📌 CRUD Kriteria
        Route::resource('kriteria', KriteriaController::class)->except(['create', 'edit', 'show']);

        // 📌 Penilaian
        Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/create', [PenilaianController::class, 'create'])->name('penilaian.create');
        Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');

        // 📌 Proses SAW
        Route::get('/saw/proses/{id}', [HasilSawController::class, 'proses'])->name('saw.proses');
    });

    /*
    |--------------------------------------------------------------------------
    | 👑 ROLE OWNER
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:owner'])->group(function () {

        // 📌 Lihat hasil ranking
        Route::get('/hasil', [HasilSawController::class, 'index'])->name('hasil.index');

        // 📌 Riwayat penilaian
        Route::get('/riwayat', [RiwayatPenilaianController::class, 'index'])->name('riwayat.index');
    });

    /*
    |--------------------------------------------------------------------------
    | 🔓 LOGOUT
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');
});
