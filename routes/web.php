<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| MASTER DATA (ADMIN ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('karyawan', KaryawanController::class);

    Route::resource('kriteria', KriteriaController::class);

    Route::resource('penilaian', PenilaianController::class);
});

/*
|--------------------------------------------------------------------------
| HASIL SAW
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,owner'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | HALAMAN HASIL SAW
    |--------------------------------------------------------------------------
    */

    Route::get('/hasil', [HasilSawController::class, 'index'])
        ->name('hasil.index');

    /*
    |--------------------------------------------------------------------------
    | PROSES PERHITUNGAN SAW
    |--------------------------------------------------------------------------
    */

    Route::post('/hasil/{penilaian}/proses', [HasilSawController::class, 'proses'])
        ->name('hasil.proses');

    /*
    |--------------------------------------------------------------------------
    | HALAMAN RANKING FINAL
    |--------------------------------------------------------------------------
    */

    Route::get('/hasil/{penilaian}/ranking', [HasilSawController::class, 'ranking'])
        ->name('hasil.ranking');
});

/*
|--------------------------------------------------------------------------
| RIWAYAT PENILAIAN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,owner'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LIST RIWAYAT
    |--------------------------------------------------------------------------
    */

    Route::get('/riwayat', [RiwayatPenilaianController::class, 'index'])
        ->name('riwayat.index');

    /*
    |--------------------------------------------------------------------------
    | DETAIL RIWAYAT
    |--------------------------------------------------------------------------
    */

    Route::get('/riwayat/{penilaian}', [RiwayatPenilaianController::class, 'show'])
        ->name('riwayat.show');

    /*
    |--------------------------------------------------------------------------
    | EXPORT LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::get('/riwayat/{penilaian}/export', [RiwayatPenilaianController::class, 'export'])
        ->name('riwayat.export');
});