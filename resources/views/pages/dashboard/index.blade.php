@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-8">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Dashboard
            </h1>

            <p class="text-slate-500 mt-1">
                Selamat datang di Sistem Pendukung Keputusan Bonus Karyawan
            </p>
        </div>

        <div class="bg-white rounded-2xl px-5 py-3 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">
                Login sebagai
            </p>

            <p class="font-bold text-ocean">
                {{ auth()->user()->name }}
            </p>
        </div>

    </div>

    {{-- ===================================================== --}}
    {{-- STATISTIK --}}
    {{-- ===================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- TOTAL KARYAWAN --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-slate-500 text-sm mb-2">
                        Total Karyawan
                    </p>

                    <h2 class="text-4xl font-bold text-slate-800">
                        {{ $totalKaryawan }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-blue-100
                            flex items-center justify-center text-3xl">
                    👨‍💼
                </div>

            </div>

        </div>

        {{-- TOTAL KRITERIA --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-slate-500 text-sm mb-2">
                        Total Kriteria
                    </p>

                    <h2 class="text-4xl font-bold text-slate-800">
                        {{ $totalKriteria }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-purple-100
                            flex items-center justify-center text-3xl">
                    📊
                </div>

            </div>

        </div>

        {{-- TOTAL PENILAIAN --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-slate-500 text-sm mb-2">
                        Total Penilaian
                    </p>

                    <h2 class="text-4xl font-bold text-slate-800">
                        {{ $totalPenilaian }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-orange-100
                            flex items-center justify-center text-3xl">
                    📝
                </div>

            </div>

        </div>

        {{-- PENERIMA BONUS --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-slate-500 text-sm mb-2">
                        Penerima Bonus
                    </p>

                    <h2 class="text-4xl font-bold text-slate-800">
                        {{ $penerimaBonus }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-green-100
                            flex items-center justify-center text-3xl">
                    🏆
                </div>

            </div>

        </div>

    </div>

    {{-- ===================================================== --}}
    {{-- TOP RANKING --}}
    {{-- ===================================================== --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="p-6 border-b border-slate-100">

            <h2 class="text-xl font-bold text-slate-800">
                Top Ranking Karyawan
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Karyawan dengan nilai SAW tertinggi
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="text-left p-4 font-semibold text-slate-600">
                            Ranking
                        </th>

                        <th class="text-left p-4 font-semibold text-slate-600">
                            Nama Karyawan
                        </th>

                        <th class="text-left p-4 font-semibold text-slate-600">
                            Nilai Akhir
                        </th>

                        <th class="text-left p-4 font-semibold text-slate-600">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($ranking as $item)

                    <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                        <td class="p-4">

                            <div class="w-10 h-10 rounded-xl bg-yellow-100
                                        flex items-center justify-center font-bold">

                                {{ $item->ranking }}

                            </div>

                        </td>

                        <td class="p-4 font-semibold text-slate-700">

                            {{ $item->karyawan->nama_karyawan }}

                        </td>

                        <td class="p-4 text-slate-600">

                            {{ number_format($item->nilai_akhir, 4) }}

                        </td>

                        <td class="p-4">

                            @if($item->status_bonus == 'Diterima')

                                <span class="px-4 py-2 rounded-full text-sm
                                             bg-green-100 text-green-700">

                                    Diterima

                                </span>

                            @else

                                <span class="px-4 py-2 rounded-full text-sm
                                             bg-red-100 text-red-700">

                                    Tidak

                                </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4"
                            class="p-6 text-center text-slate-400">

                            Belum ada data ranking

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection