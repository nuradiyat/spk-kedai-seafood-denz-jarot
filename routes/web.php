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

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD (SEMUA USER LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('karyawan', KaryawanController::class);
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('penilaian', PenilaianController::class);
});

/*
|--------------------------------------------------------------------------
| ADMIN & OWNER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,owner'])->group(function () {

    Route::get('/hasil', [HasilSawController::class, 'index'])
        ->name('hasil.index');

    // bagian sini eror sat masuk das dasboar index.blade.php  <a href="{{ route('hasil.index') }}" 
    // tidak bisa masuk karena butuh {{ $penilai->id }} jadi harusnya route nya gini route('hasil.index', $penilai->id) 
    //tapi karena di dashboard index.blade.php belum ada variabel $penilai jadi error, jadi untuk sementara saya buat route hasil.index tanpa parameter dulu, nanti kalau mau masukin parameter tinggal hapus aja route hasil.index yang tanpa parameter terus uncomment route hasil.index yang dengan parameter terus masukin variabel $penilai di dashboard index.blade.php
    // Route::get('/hasil/{penilaian}/detail', [HasilSawController::class, 'detail'])
    //     ->name('hasil.detail');
    Route::get('/hasil/detail', [HasilSawController::class, 'detail'])
        ->name('hasil.detail');

    Route::post('/hasil/{penilaian}/proses', [HasilSawController::class, 'proses'])
        ->name('hasil.proses');

    Route::get('/riwayat', [RiwayatPenilaianController::class, 'index'])
        ->name('riwayat.index');

    Route::get('/riwayat/{penilaian}', [RiwayatPenilaianController::class, 'detail'])
        ->name('riwayat.detail');
});