@extends('layouts.app')

@section('title', 'Podium Ranking')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Podium Karyawan Terbaik
            </h1>

            <p class="text-slate-500 mt-1">
                Ranking 3 besar hasil perhitungan metode SAW
            </p>

        </div>

        <a href="{{ route('hasil.index') }}"
           class="inline-flex items-center px-5 py-3 rounded-2xl
                  bg-slate-700 hover:bg-slate-800
                  text-white font-semibold transition">

            ← Kembali

        </a>

    </div>

    {{-- PODIUM --}}
    <div class="grid md:grid-cols-3 gap-6 items-end">

        {{-- JUARA 2 --}}
        @if(isset($topRank[1]))

        <div class="bg-white rounded-3xl shadow-xl p-8 text-center">

            <div class="text-6xl mb-4">
                🥈
            </div>

            <div class="w-24 h-24 mx-auto rounded-3xl
                        bg-gradient-to-br from-slate-400 to-slate-600
                        flex items-center justify-center
                        text-white text-4xl font-bold mb-5">

                {{ strtoupper(substr($topRank[1]->karyawan->nama_karyawan, 0, 1)) }}

            </div>

            <h2 class="text-2xl font-bold text-slate-800">
                {{ $topRank[1]->karyawan->nama_karyawan }}
            </h2>

            <p class="text-slate-500 mt-2">
                Ranking #2
            </p>

            <div class="mt-6 bg-slate-100 rounded-2xl py-4">

                <p class="text-sm text-slate-500">
                    Nilai Akhir
                </p>

                <h3 class="text-3xl font-bold text-slate-800">
                    {{ number_format($topRank[1]->nilai_akhir, 4) }}
                </h3>

            </div>

        </div>

        @endif

        {{-- JUARA 1 --}}
        @if(isset($topRank[0]))

        <div class="bg-gradient-to-br from-cyan-500 to-blue-600
                    rounded-3xl shadow-2xl p-10 text-center
                    text-white scale-105">

            <div class="text-7xl mb-4">
                🏆
            </div>

            <div class="w-28 h-28 mx-auto rounded-3xl
                        bg-white/20 backdrop-blur
                        flex items-center justify-center
                        text-white text-5xl font-bold mb-6">

                {{ strtoupper(substr($topRank[0]->karyawan->nama_karyawan, 0, 1)) }}

            </div>

            <h2 class="text-3xl font-bold">
                {{ $topRank[0]->karyawan->nama_karyawan }}
            </h2>

            <p class="text-cyan-100 mt-2">
                Juara 1 • Karyawan Terbaik
            </p>

            <div class="mt-8 bg-white/20 rounded-2xl py-5">

                <p class="text-sm text-cyan-100">
                    Nilai Tertinggi
                </p>

                <h3 class="text-4xl font-bold">
                    {{ number_format($topRank[0]->nilai_akhir, 4) }}
                </h3>

            </div>

        </div>

        @endif

        {{-- JUARA 3 --}}
        @if(isset($topRank[2]))

        <div class="bg-white rounded-3xl shadow-xl p-8 text-center">

            <div class="text-6xl mb-4">
                🥉
            </div>

            <div class="w-24 h-24 mx-auto rounded-3xl
                        bg-gradient-to-br from-amber-600 to-orange-700
                        flex items-center justify-center
                        text-white text-4xl font-bold mb-5">

                {{ strtoupper(substr($topRank[2]->karyawan->nama_karyawan, 0, 1)) }}

            </div>

            <h2 class="text-2xl font-bold text-slate-800">
                {{ $topRank[2]->karyawan->nama_karyawan }}
            </h2>

            <p class="text-slate-500 mt-2">
                Ranking #3
            </p>

            <div class="mt-6 bg-slate-100 rounded-2xl py-4">

                <p class="text-sm text-slate-500">
                    Nilai Akhir
                </p>

                <h3 class="text-3xl font-bold text-slate-800">
                    {{ number_format($topRank[2]->nilai_akhir, 4) }}
                </h3>

            </div>

        </div>

        @endif

    </div>

</div>

@endsection