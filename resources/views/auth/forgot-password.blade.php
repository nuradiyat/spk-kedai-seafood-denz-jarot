{{--
================================================================
FILE    : auth/forgot-password.blade.php
FUNGSI  : Halaman lupa password.
LAYOUT  : layouts/guest.blade.php
================================================================
--}}
@extends('layouts.guest')
@section('title', 'Lupa Password')

@section('content')
    <div class="bg-white rounded-3xl shadow-2xl p-10 sm:p-12">

        {{-- Brand --}}
        <div class="flex items-center gap-4 mb-8">
            <div
                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-ocean to-ocean-lt
                    flex items-center justify-center text-2xl shrink-0">
                🐟</div>
            <div>
                <h1 class="font-heading font-bold text-ocean text-lg leading-tight">Denz Jarot Seafood</h1>
                <p class="text-slate-400 text-xs mt-0.5">Reset Password</p>
            </div>
        </div>

        {{-- Icon --}}
        <div
            class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-200
                flex items-center justify-center mb-5">
            <i class="fas fa-key text-amber-500 text-xl"></i>
        </div>

        <h2 class="font-heading font-bold text-ocean text-2xl mb-1">Lupa Password?</h2>
        <p class="text-slate-400 text-sm mb-8">Hubungi administrator untuk mereset password Anda.</p>

        {{-- Info box --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-4 mb-6 flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-400 mt-0.5 shrink-0"></i>
            <p class="text-sm text-blue-700">
                Sistem ini hanya dapat diakses oleh pemilik usaha (owner).
                Hubungi pengembang sistem jika tidak dapat masuk.
            </p>
        </div>

        <a href="#"
            class="flex items-center justify-center gap-2 w-full py-3 rounded-xl border-2 border-slate-200
              text-slate-600 text-sm font-medium hover:bg-slate-50 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Login
        </a>

    </div>
@endsection
