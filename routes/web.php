<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\HasilSawController;
use App\Http\Controllers\RiwayatPenilaianController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

/**
 * =========================================
 * HALAMAN LOGIN
 * =========================================
 */
Route::get('/', [AuthController::class, 'showLogin'])
    ->name('login');

/**
 * =========================================
 * PROSES LOGIN
 * =========================================
 */
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

/**
 * =========================================
 * LOGOUT
 * =========================================
 */
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD (SEMUA ROLE)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /**
     * =========================================
     * DASHBOARD
     * =========================================
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});


/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
|
| Admin:
| - CRUD Karyawan
| - CRUD Kriteria
| - Input Penilaian
|
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    /**
     * =========================================
     * DATA KARYAWAN
     * =========================================
     */
    Route::resource('karyawan', KaryawanController::class);

    /**
     * =========================================
     * KRITERIA & BOBOT
     * =========================================
     */
    Route::resource('kriteria', KriteriaController::class);

    /**
     * =========================================
     * INPUT PENILAIAN
     * =========================================
     */
    Route::resource('penilaian', PenilaianController::class);
});


/*
|--------------------------------------------------------------------------
| ADMIN & OWNER
|--------------------------------------------------------------------------
|
| Admin dan Owner:
| - Melihat proses SAW
| - Hasil ranking
| - Riwayat
| - Export laporan
|
*/

Route::middleware(['auth', 'role:admin,owner'])->group(function () {

    /**
     * =========================================
     * HALAMAN PERHITUNGAN SAW
     * =========================================
     */
    Route::get('/penilaian/saw', [HasilSawController::class, 'saw'])
        ->name('penilaian.saw');

    /**
     * =========================================
     * HALAMAN NORMALISASI
     * =========================================
     */
    Route::get('/penilaian/normalisasi', [HasilSawController::class, 'normalisasi'])
        ->name('penilaian.normalisasi');

    /**
     * =========================================
     * HASIL RANKING
     * =========================================
     */
    Route::get('/hasil', [HasilSawController::class, 'index'])
        ->name('hasil.index');

    /**
     * =========================================
     * DETAIL HASIL
     * =========================================
     */
    Route::get('/hasil/{penilaian}', [HasilSawController::class, 'detail'])
        ->name('hasil.detail');

    /**
     * =========================================
     * PODIUM TOP 3
     * =========================================
     */
    Route::get('/hasil/podium', [HasilSawController::class, 'podium'])
        ->name('hasil.podium');

    /**
     * =========================================
     * PROSES PERHITUNGAN SAW
     * =========================================
     */
    Route::post('/hasil/proses', [HasilSawController::class, 'proses'])
        ->name('hasil.proses');

    /**
     * =========================================
     * RIWAYAT PENILAIAN
     * =========================================
     */
    Route::get('/riwayat', [RiwayatPenilaianController::class, 'index'])
        ->name('riwayat.index');

    /**
     * =========================================
     * DETAIL RIWAYAT
     * =========================================
     */
    Route::get('/riwayat/{penilaian}', [RiwayatPenilaianController::class, 'detail'])
        ->name('riwayat.detail');

    /**
     * =========================================
     * EXPORT LAPORAN
     * =========================================
     */
    Route::get('/riwayat/export/pdf', [RiwayatPenilaianController::class, 'export'])
        ->name('riwayat.export');
});