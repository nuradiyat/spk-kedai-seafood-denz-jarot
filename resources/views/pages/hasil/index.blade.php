{{-- 
================================================================
pages/hasil/index.blade.php

FUNGSI  :
Halaman utama proses SAW.

Menampilkan:
1. Header halaman
2. Step proses SAW
3. Informasi bobot kriteria
4. Partial matrix
5. Partial max/min
6. Partial normalisasi
7. Partial pembobotan
8. Partial kesimpulan

Controller :
HasilSawController@index
================================================================
--}}

@extends('layouts.app')

@section('title', 'Perhitungan SAW')

@section('page-title', 'Perhitungan SAW')

@section('page-subtitle')
    Periode :
    {{ \Carbon\Carbon::createFromFormat('Y-m', $penilaian->periode)->translatedFormat('F Y') }}
@endsection

@section('content')

    {{-- ===================================================== --}}
    {{-- BREADCRUMB --}}
    {{-- ===================================================== --}}
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-5">

        <a href="{{ route('dashboard') }}" class="hover:text-ocean transition-colors">
            Dashboard
        </a>

        <i class="fas fa-chevron-right text-[10px]"></i>

        <span class="text-slate-600 font-medium">
            Hasil SAW
        </span>

    </nav>

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">

        <div>
            <h1 class="font-heading font-bold text-2xl text-ocean">
                Proses Perhitungan SAW
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Periode :
                <span class="font-semibold text-ocean">
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $penilaian->periode)->translatedFormat('F Y') }}
                </span>
            </p>
        </div>

        <div class="flex items-center gap-2">

            {{-- Tombol Hitung Ulang --}}
            <form action="{{ route('hasil.proses', $penilaian->id) }}" method="POST">

                @csrf

                <button type="submit"
                    class="inline-flex items-center gap-2
                           bg-gradient-to-r from-teal-600 to-teal
                           text-white text-sm font-semibold
                           px-5 py-2.5 rounded-xl
                           hover:shadow-lg transition-all">

                    <i class="fas fa-sync-alt text-xs"></i>

                    Hitung Ulang

                </button>

            </form>

            {{-- Tombol Ranking --}}
            <a href="{{ route('hasil.ranking', $penilaian->id) }}"
                class="inline-flex items-center gap-2
                       bg-gradient-to-r from-ocean to-ocean-lt
                       text-white text-sm font-semibold
                       px-5 py-2.5 rounded-xl
                       hover:shadow-lg transition-all">

                <i class="fas fa-trophy text-xs"></i>

                Lihat Ranking

            </a>

        </div>

    </div>

    {{-- ===================================================== --}}
    {{-- STEP PROSES SAW --}}
    {{-- ===================================================== --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 mb-6 overflow-x-auto">

        <div class="flex items-center gap-4 min-w-max">

            {{-- Step 1 --}}
            <a href="#matrix" class="flex items-center gap-2">

                <div
                    class="w-9 h-9 rounded-full
                            bg-gradient-to-br from-ocean to-ocean-lt
                            flex items-center justify-center
                            text-white font-bold text-sm">

                    1

                </div>

                <div class="hidden md:block">
                    <p class="text-xs font-semibold text-ocean">
                        Matriks
                    </p>

                    <p class="text-[10px] text-slate-400">
                        Nilai Asli
                    </p>
                </div>

            </a>

            {{-- Garis --}}
            <div class="w-10 h-0.5 bg-slate-200"></div>

            {{-- Step 2 --}}
            <a href="#max" class="flex items-center gap-2">

                <div
                    class="w-9 h-9 rounded-full
                            bg-gradient-to-br from-ocean to-ocean-lt
                            flex items-center justify-center
                            text-white font-bold text-sm">

                    2

                </div>

                <div class="hidden md:block">
                    <p class="text-xs font-semibold text-ocean">
                        Max & Min
                    </p>

                    <p class="text-[10px] text-slate-400">
                        Benefit / Cost
                    </p>
                </div>

            </a>

            <div class="w-10 h-0.5 bg-slate-200"></div>

            {{-- Step 3 --}}
            <a href="#normalisasi" class="flex items-center gap-2">

                <div
                    class="w-9 h-9 rounded-full
                            bg-gradient-to-br from-ocean to-ocean-lt
                            flex items-center justify-center
                            text-white font-bold text-sm">

                    3

                </div>

                <div class="hidden md:block">
                    <p class="text-xs font-semibold text-ocean">
                        Normalisasi
                    </p>

                    <p class="text-[10px] text-slate-400">
                        Matriks R
                    </p>
                </div>

            </a>

            <div class="w-10 h-0.5 bg-slate-200"></div>

            {{-- Step 4 --}}
            <a href="#pembobotan" class="flex items-center gap-2">

                <div
                    class="w-9 h-9 rounded-full
                            bg-gradient-to-br from-ocean to-ocean-lt
                            flex items-center justify-center
                            text-white font-bold text-sm">

                    4

                </div>

                <div class="hidden md:block">
                    <p class="text-xs font-semibold text-ocean">
                        Pembobotan
                    </p>

                    <p class="text-[10px] text-slate-400">
                        Nilai Akhir
                    </p>
                </div>

            </a>

            <div class="w-10 h-0.5 bg-slate-200"></div>

            {{-- Step 5 --}}
            <a href="#kesimpulan" class="flex items-center gap-2">

                <div
                    class="w-9 h-9 rounded-full
                            bg-gradient-to-br from-ocean to-ocean-lt
                            flex items-center justify-center
                            text-white font-bold text-sm">

                    5

                </div>

                <div class="hidden md:block">
                    <p class="text-xs font-semibold text-ocean">
                        Kesimpulan
                    </p>

                    <p class="text-[10px] text-slate-400">
                        Ranking
                    </p>
                </div>

            </a>

        </div>

    </div>

    {{-- ===================================================== --}}
    {{-- BOBOT KRITERIA --}}
    {{-- ===================================================== --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 mb-6">

        <div class="flex flex-wrap gap-2 items-center">

            <span class="text-xs font-semibold text-slate-500">
                Bobot :
            </span>

            @foreach ($hasil['kriterias'] as $kriteria)
                <div
                    class="flex items-center gap-2
                            bg-slate-50 border border-slate-200
                            rounded-xl px-3 py-2">

                    <span class="font-bold text-ocean text-xs">
                        {{ $kriteria->kode }}
                    </span>

                    <span class="text-xs text-slate-400">
                        {{ $kriteria->nama }}
                    </span>

                    <span class="font-bold text-xs text-ocean">
                        W = {{ $kriteria->bobot }}
                    </span>

                </div>
            @endforeach

        </div>

    </div>

    {{-- ===================================================== --}}
    {{-- PARTIAL MATRIX --}}
    {{-- ===================================================== --}}
    <div id="matrix" class="scroll-mt-20">

        @include('pages.hasil.partials.matrix')

    </div>

    {{-- ===================================================== --}}
    {{-- PARTIAL MAX MIN --}}
    {{-- ===================================================== --}}
    <div id="max" class="scroll-mt-20 mt-5">

        @include('pages.hasil.partials.max')

    </div>

    {{-- ===================================================== --}}
    {{-- PARTIAL NORMALISASI --}}
    {{-- ===================================================== --}}
    <div id="normalisasi" class="scroll-mt-20 mt-5">

        @include('pages.hasil.partials.normalisasi')

    </div>

    {{-- ===================================================== --}}
    {{-- PARTIAL PEMBOBOTAN --}}
    {{-- ===================================================== --}}
    <div id="pembobotan" class="scroll-mt-20 mt-5">

        @include('pages.hasil.partials.pembobotan')

    </div>

    {{-- ===================================================== --}}
    {{-- PARTIAL KESIMPULAN --}}
    {{-- ===================================================== --}}
    <div id="kesimpulan" class="scroll-mt-20 mt-5">

        @include('pages.hasil.partials.kesimpulan')

    </div>

    {{-- ===================================================== --}}
    {{-- FOOTER CTA --}}
    {{-- ===================================================== --}}
    <div
        class="mt-6
                bg-gradient-to-r from-ocean to-ocean-lt
                rounded-2xl p-6
                flex flex-col sm:flex-row
                items-center justify-between gap-4">

        <div class="text-white">

            <p class="font-heading font-bold text-lg">
                Perhitungan selesai!
            </p>

            <p class="text-sm text-white/70 mt-1">
                Lihat ranking final penerima bonus.
            </p>

        </div>

        <a href="{{ route('hasil.ranking', $penilaian->id) }}"
            class="inline-flex items-center gap-2
                   bg-white text-ocean
                   px-6 py-3 rounded-xl
                   font-bold text-sm
                   hover:shadow-xl transition-all">

            <i class="fas fa-trophy text-sm"></i>

            Lihat Ranking Final

        </a>

    </div>

@endsection
