{{--
================================================================
FILE    : auth/login.blade.php
FUNGSI  : Halaman login sistem SPK.
          Form email, password, tombol masuk, link lupa password.
LAYOUT  : layouts/guest.blade.php
================================================================
--}}
@extends('layouts.guest')
@section('title', 'Login — SPK Denz Jarot')

@section('content')
<div class="bg-white rounded-3xl shadow-2xl p-10 sm:p-12">

    {{-- ===== BRAND HEADER ===== --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-ocean to-ocean-lt
                    flex items-center justify-center text-2xl shrink-0">🐟</div>
        <div>
            <h1 class="font-heading font-bold text-ocean text-lg leading-tight">Denz Jarot Seafood</h1>
            <p class="text-slate-400 text-xs mt-0.5">Sistem Pendukung Keputusan</p>
        </div>
    </div>

    {{-- ===== JUDUL ===== --}}
    <h2 class="font-heading font-bold text-ocean text-2xl mb-1">Selamat Datang</h2>
    <p class="text-slate-400 text-sm mb-8">Masuk untuk mengelola penilaian karyawan</p>

    {{-- ===== ALERT ERROR (dummy) ===== --}}
    @include('components.alerts.error')

    {{-- ===== FORM LOGIN ===== --}}
    <form action="{{ route('login.process' ) }}" method="POST">
        @csrf
        {{-- Input email --}}
        <div class="mb-5">
            <label class="block text-sm font-semibold text-slate-600 mb-2" for="email">email</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
                    <i class="fas fa-user"></i>
                </span>
                <input id="email" name="email" type="email" placeholder="Masukkan email"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                              text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                              transition-all duration-200">
            </div>
        </div>

        {{-- Input Password --}}
        <div class="mb-7">
            <div class="flex items-center justify-between mb-2">
                <label class="text-sm font-semibold text-slate-600" for="password">Password</label>
                <a href="#" class="text-xs text-teal hover:underline">Lupa password?</a>
            </div>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
                    <i class="fas fa-lock"></i>
                </span>
                <input id="password" name="password" type="password" placeholder="Masukkan password"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                              text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                              transition-all duration-200">
            </div>
        </div>

        {{-- Tombol Masuk --}}
        <button type="submit"
                class="w-full py-3.5 rounded-xl font-heading font-semibold text-white text-[15px]
                       bg-gradient-to-r from-ocean to-ocean-lt tracking-wide
                       hover:-translate-y-0.5 hover:shadow-lg hover:shadow-ocean/30
                       active:translate-y-0 transition-all duration-200">
            <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Sistem
        </button>

    </form>

</div>
@endsection