<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\HasilSawController;
use App\Http\Controllers\RiwayatPenilaianController;


// ROUTE UNTUK AUTENTIKASI
Route::get('/', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ROUTE UNTUK DASHBOARD, KARYAWAN, KRITERIA, PENILAIAN, HASIL SAW, RIWAYAT PENILAIAN
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});


// ADMIN ONLY
Route::middleware(['auth', 'role:admin'])->group(function () {

    // CRUD KARYAWAN, KRITERIA, PENILAIAN
    Route::resource('karyawan', KaryawanController::class);

    Route::resource('kriteria', KriteriaController::class);

    // CRUD PENILAIAN, termasuk proses SAW dan hitung ulang
    Route::resource('penilaian', PenilaianController::class);

    // PROSES SAW
    Route::post('/penilaian/{penilaian}/proses-saw', [HasilSawController::class, 'proses'])
        ->name('penilaian.proses');

    // HITUNG ULANG SAW
    Route::post('/penilaian/{penilaian}/hitung-ulang', [HasilSawController::class, 'hitungUlang'])
        ->name('penilaian.hitung-ulang');
});

// owner only
Route::middleware(['auth', 'role:owner'])->group(function () {

    // bonus 
    Route::resource('bonus', BonusController::class);
});


// ADMIN & OWNER ONLY - HASIL RANKING PER PERIODE, DETAIL HASIL RANKING PER PERIODE
Route::middleware(['auth', 'role:admin,owner'])->group(function () {

    // HASIL RANKING PER PERIODE
    Route::get('/hasil', [HasilSawController::class, 'index'])
        ->name('hasil.index');

    // DETAIL HASIL RANKING PER PERIODE
    Route::get('/hasil/{penilaian}', [HasilSawController::class, 'detail'])
        ->name('hasil.detail');
});


// ADMIN & OWNER ONLY - RIWAYAT PENILAIAN, EXPORT PDF & EXCEL
Route::middleware(['auth', 'role:admin,owner'])->group(function () {

    // RIWAYAT PENILAIAN PER PERIODE
    Route::get('/riwayat', [RiwayatPenilaianController::class, 'index'])
        ->name('riwayat.index');

    // DETAIL RIWAYAT PENILAIAN PER PERIODE
    Route::get('/riwayat/{penilaian}', [RiwayatPenilaianController::class, 'detail'])
        ->name('riwayat.detail');

    // EXPORT PDF LAPORAN
    Route::get('/riwayat/{penilaian}/export-pdf', [RiwayatPenilaianController::class, 'exportPdf'])
        ->name('riwayat.export-pdf');

    // EXPORT EXCEL LAPORAN
    Route::get('/riwayat/{penilaian}/export-excel', [RiwayatPenilaianController::class, 'exportExcel'])
        ->name('riwayat.export-excel');
});