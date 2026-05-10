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
     * PENILAIAN
     * =========================================
     */
    Route::resource('penilaian', PenilaianController::class);
});


/*
|--------------------------------------------------------------------------
| ADMIN & OWNER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,owner'])->group(function () {

    /**
     * =========================================
     * HASIL SAW
     * =========================================
     */
    Route::get('/hasil', [HasilSawController::class, 'index'])
        ->name('hasil.index');

    /**
     * =========================================
     * DETAIL PERHITUNGAN SAW
     * =========================================
     */
    Route::get('/hasil/{penilaian}/detail', [HasilSawController::class, 'detail'])
        ->name('hasil.detail');

    /**
     * =========================================
     * PROSES PERHITUNGAN SAW
     * =========================================
     */
    Route::post('/hasil/{penilaian}/proses', [HasilSawController::class, 'proses'])
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
});
