{{--
================================================================
pages/hasil/ranking.blade.php

FUNGSI  : Halaman ranking akhir SAW.
           - Podium Top 3
           - Statistik ringkasan
           - Ranking lengkap
           - Daftar penerima bonus

Controller : HasilSawController@ranking
Route      : GET /hasil/{penilaian}/ranking → hasil.ranking
================================================================
--}}

@extends('layouts.app')

@section('title', 'Ranking SAW — ' . \Carbon\Carbon::createFromFormat('Y-m', $penilaian->periode)->translatedFormat('F
    Y'))

@section('page-title', 'Ranking Penerima Bonus')

@section('page-subtitle', 'Hasil akhir metode SAW — ' . \Carbon\Carbon::createFromFormat('Y-m',
    $penilaian->periode)->translatedFormat('F Y'))

@section('content')

    @php
        $periode = \Carbon\Carbon::createFromFormat('Y-m', $penilaian->periode)->translatedFormat('F Y');

        $rank1 = $hasilSaws->firstWhere('ranking', 1);
        $rank2 = $hasilSaws->firstWhere('ranking', 2);
        $rank3 = $hasilSaws->firstWhere('ranking', 3);

        $totalBonus = $hasilSaws->where('penerima_bonus', true)->sum('jumlah_bonus');
        $totalPenerima = $hasilSaws->where('penerima_bonus', true)->count();
    @endphp

    {{-- ======================================================
         BREADCRUMB
    ======================================================= --}}
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-5">
        <a href="{{ route('dashboard') }}" class="hover:text-ocean transition-colors">
            Dashboard
        </a>

        <i class="fas fa-chevron-right text-[10px]"></i>

        <a href="{{ route('hasil.index', $penilaian->id) }}" class="hover:text-ocean transition-colors">
            Hasil SAW
        </a>

        <i class="fas fa-chevron-right text-[10px]"></i>

        <span class="text-slate-600 font-medium">
            Ranking Final
        </span>
    </nav>

    {{-- ======================================================
         HEADER
    ======================================================= --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">

        <div class="flex items-start gap-3">

            <a href="{{ route('hasil.index', $penilaian->id) }}"
                class="w-10 h-10 rounded-xl border border-slate-200 bg-white
                       text-slate-500 flex items-center justify-center
                       hover:bg-slate-50 transition-colors shrink-0">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>

            <div>
                <h1 class="font-heading font-bold text-ocean text-2xl">
                    Ranking Final SAW
                </h1>

                <p class="text-slate-400 text-sm mt-1">
                    {{ $periode }}
                    &mdash;
                    {{ $hasilSaws->count() }} karyawan
                </p>
            </div>

        </div>

        <div class="flex flex-wrap items-center gap-2 no-print">

            <a href="{{ route('riwayat.index') }}"
                class="inline-flex items-center gap-2 border border-slate-200 bg-white
                       text-slate-600 text-sm font-medium px-4 py-2.5 rounded-xl
                       hover:bg-slate-50 transition-colors">

                <i class="fas fa-history text-xs"></i>
                Riwayat

            </a>

            <button onclick="window.print()"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
                       text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                       hover:-translate-y-0.5 hover:shadow-lg hover:shadow-ocean/20
                       transition-all duration-200">

                <i class="fas fa-print text-xs"></i>
                Cetak

            </button>

        </div>

    </div>

    {{-- ======================================================
         STATISTIC CARDS
    ======================================================= --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        {{-- Total Karyawan --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

            <div class="w-10 h-10 rounded-xl bg-ocean/10 flex items-center justify-center mb-3">
                <i class="fas fa-users text-ocean"></i>
            </div>

            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">
                Total Karyawan
            </p>

            <p class="font-heading font-bold text-ocean text-2xl mt-1">
                {{ $hasilSaws->count() }}
            </p>

        </div>

        {{-- Penerima Bonus --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

            <div class="w-10 h-10 rounded-xl bg-teal/10 flex items-center justify-center mb-3">
                <i class="fas fa-trophy text-teal-600"></i>
            </div>

            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">
                Penerima Bonus
            </p>

            <p class="font-heading font-bold text-ocean text-2xl mt-1">
                {{ $totalPenerima }}
            </p>

        </div>

        {{-- Nilai Tertinggi --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

            <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center mb-3">
                <i class="fas fa-crown text-yellow-500"></i>
            </div>

            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">
                Nilai Vi Tertinggi
            </p>

            <p class="font-heading font-bold text-ocean text-2xl mt-1">
                {{ $rank1 ? number_format($rank1->nilai_akhir, 4) : '—' }}
            </p>

        </div>

        {{-- Total Bonus --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

            <div class="w-10 h-10 rounded-xl bg-coral/10 flex items-center justify-center mb-3">
                <i class="fas fa-money-bill-wave text-coral"></i>
            </div>

            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">
                Total Bonus
            </p>

            <p class="font-heading font-bold text-ocean text-lg mt-1">
                Rp {{ number_format($totalBonus, 0, ',', '.') }}
            </p>

        </div>

    </div>

    {{-- ======================================================
         PODIUM TOP 3
    ======================================================= --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

        <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 bg-slate-50/50">

            <div class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-award text-yellow-500 text-sm"></i>
            </div>

            <h3 class="font-heading font-bold text-ocean text-[15px]">
                Podium Terbaik — {{ $periode }}
            </h3>

        </div>

        <div class="flex items-end justify-center gap-4 sm:gap-10 px-6 py-8 overflow-x-auto">

            {{-- =========================
                 RANK 2
            ========================== --}}
            @if ($rank2)
                <div class="flex flex-col items-center gap-2 shrink-0">

                    <div
                        class="w-16 h-16 rounded-2xl flex items-center justify-center
                               text-white text-xl font-heading font-bold shadow-lg
                               bg-gradient-to-br {{ $rank2->karyawan->warna ?? 'from-slate-400 to-slate-600' }}">

                        {{ strtoupper(substr($rank2->karyawan->nama_karyawan, 0, 2)) }}

                    </div>

                    <div class="text-center">

                        <p class="font-heading font-bold text-slate-700 text-sm max-w-[120px] truncate">
                            {{ $rank2->karyawan->nama_karyawan }}
                        </p>

                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ number_format($rank2->nilai_akhir, 4) }}
                        </p>

                    </div>

                    <div
                        class="w-24 h-20 rounded-t-2xl bg-gradient-to-t from-slate-400 to-slate-300
                               flex items-center justify-center shadow-md">

                        <div class="text-center text-white">

                            <div class="text-2xl">🥈</div>

                            <div class="font-heading font-black text-lg">
                                2
                            </div>

                        </div>

                    </div>

                </div>
            @endif

            {{-- =========================
                 RANK 1
            ========================== --}}
            @if ($rank1)
                <div class="flex flex-col items-center gap-2 -mb-2 shrink-0">

                    <div class="text-3xl">👑</div>

                    <div
                        class="w-20 h-20 rounded-2xl flex items-center justify-center
                               text-white text-2xl font-heading font-bold
                               shadow-xl ring-4 ring-yellow-200
                               bg-gradient-to-br {{ $rank1->karyawan->warna ?? 'from-yellow-400 to-yellow-600' }}">

                        {{ strtoupper(substr($rank1->karyawan->nama_karyawan, 0, 2)) }}

                    </div>

                    <div class="text-center">

                        <p class="font-heading font-bold text-ocean text-base max-w-[130px] truncate">
                            {{ $rank1->karyawan->nama_karyawan }}
                        </p>

                        <p class="text-sm font-bold text-yellow-600 mt-0.5">
                            {{ number_format($rank1->nilai_akhir, 4) }}
                        </p>

                    </div>

                    <div
                        class="w-28 h-32 rounded-t-2xl bg-gradient-to-t from-yellow-500 to-yellow-300
                               flex items-center justify-center shadow-xl">

                        <div class="text-center text-white">

                            <div class="text-3xl">🥇</div>

                            <div class="font-heading font-black text-2xl">
                                1
                            </div>

                        </div>

                    </div>

                </div>
            @endif

            {{-- =========================
                 RANK 3
            ========================== --}}
            @if ($rank3)
                <div class="flex flex-col items-center gap-2 shrink-0">

                    <div
                        class="w-16 h-16 rounded-2xl flex items-center justify-center
                               text-white text-xl font-heading font-bold shadow-lg
                               bg-gradient-to-br {{ $rank3->karyawan->warna ?? 'from-orange-400 to-orange-600' }}">

                        {{ strtoupper(substr($rank3->karyawan->nama_karyawan, 0, 2)) }}

                    </div>

                    <div class="text-center">

                        <p class="font-heading font-bold text-slate-700 text-sm max-w-[120px] truncate">
                            {{ $rank3->karyawan->nama_karyawan }}
                        </p>

                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ number_format($rank3->nilai_akhir, 4) }}
                        </p>

                    </div>

                    <div
                        class="w-24 h-14 rounded-t-2xl bg-gradient-to-t from-orange-500 to-orange-300
                               flex items-center justify-center shadow-md">

                        <div class="text-center text-white">

                            <div class="text-2xl">🥉</div>

                            <div class="font-heading font-black text-lg">
                                3
                            </div>

                        </div>

                    </div>

                </div>
            @endif

        </div>

    </div>

    {{-- ======================================================
         TABEL RANKING
    ======================================================= --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">

            <div class="flex items-center gap-3">

                <div class="w-8 h-8 rounded-lg bg-ocean/10 flex items-center justify-center">
                    <i class="fas fa-list-ol text-ocean text-sm"></i>
                </div>

                <h3 class="font-heading font-bold text-ocean text-[15px]">
                    Tabel Ranking Lengkap
                </h3>

            </div>

            <span class="text-xs text-slate-400 hidden sm:block">
                Diurutkan dari nilai Vi tertinggi
            </span>

        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm min-w-[850px]">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th
                            class="px-5 py-3.5 text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide">
                            Rank
                        </th>

                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide">
                            Karyawan
                        </th>

                        <th
                            class="px-4 py-3.5 text-center text-[11px] font-bold text-teal-700 uppercase tracking-wide bg-teal-bg/30">
                            Nilai Vi
                        </th>

                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide">
                            Progress
                        </th>

                        <th
                            class="px-4 py-3.5 text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide">
                            Bonus
                        </th>

                        <th
                            class="px-4 py-3.5 text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($hasilSaws as $h)
                        @php
                            $rowBg = match ($h->ranking) {
                                1 => 'bg-yellow-50/60',
                                2 => 'bg-slate-50/40',
                                3 => 'bg-orange-50/40',
                                default => 'bg-white',
                            };

                            $badge = match ($h->ranking) {
                                1 => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                2 => 'bg-slate-200 text-slate-600',
                                3 => 'bg-orange-100 text-orange-600 border border-orange-200',
                                default => 'bg-slate-100 text-slate-500',
                            };
                        @endphp

                        <tr
                            class="{{ $rowBg }}
                                   border-b border-slate-100 last:border-0
                                   hover:brightness-95 transition-all">

                            {{-- Rank --}}
                            <td class="px-5 py-4 text-center">

                                <span
                                    class="{{ $badge }}
                                           inline-flex items-center justify-center
                                           w-8 h-8 rounded-xl
                                           font-heading font-bold text-sm">

                                    {{ $h->ranking }}

                                </span>

                            </td>

                            {{-- Karyawan --}}
                            <td class="px-4 py-4">

                                <div class="flex items-center gap-3">

                                    <span
                                        class="w-10 h-10 rounded-xl flex items-center justify-center
                                               text-white text-xs font-bold font-heading shadow-sm
                                               bg-gradient-to-br {{ $h->karyawan->warna ?? 'from-slate-400 to-slate-600' }}">

                                        {{ strtoupper(substr($h->karyawan->nama_karyawan, 0, 2)) }}

                                    </span>

                                    <div>

                                        <p class="font-semibold text-slate-800">
                                            {{ $h->karyawan->nama_karyawan }}
                                        </p>

                                        <p class="text-[11px] text-slate-400">
                                            {{ $h->karyawan->jabatan ?? '—' }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            {{-- Nilai Vi --}}
                            <td class="px-4 py-4 text-center bg-teal-bg/10">

                                <span
                                    class="font-heading font-bold text-lg
                                           {{ $h->ranking <= 3 ? 'text-teal-700' : 'text-slate-600' }}">

                                    {{ number_format($h->nilai_akhir, 4) }}

                                </span>

                            </td>

                            {{-- Progress --}}
                            <td class="px-4 py-4">

                                <div class="flex items-center gap-2.5">

                                    <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden min-w-[100px]">

                                        <div class="h-full rounded-full bg-teal"
                                            style="width: {{ round($h->nilai_akhir * 100, 1) }}%">
                                        </div>

                                    </div>

                                    <span class="text-xs text-slate-400 font-mono w-12 text-right">
                                        {{ round($h->nilai_akhir * 100, 1) }}%
                                    </span>

                                </div>

                            </td>

                            {{-- Bonus --}}
                            <td class="px-4 py-4 text-center">

                                @if ($h->jumlah_bonus > 0)
                                    <span class="font-semibold text-teal-600">
                                        Rp {{ number_format($h->jumlah_bonus, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif

                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4 text-center">

                                @if ($h->penerima_bonus)
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-teal-bg text-teal-700
                                               border border-teal-200 px-3 py-1.5 rounded-full
                                               text-xs font-semibold">

                                        <i class="fas fa-check-circle text-[10px]"></i>
                                        Penerima Bonus

                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-500
                                               px-3 py-1.5 rounded-full text-xs font-semibold">

                                        Belum Memenuhi

                                    </span>
                                @endif

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- Footer --}}
        <div
            class="px-6 py-4 border-t border-slate-100 bg-slate-50/50
                   flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div class="flex flex-wrap items-center gap-4 text-sm">

                <span class="text-slate-500">

                    <i class="fas fa-check-circle text-teal mr-1"></i>

                    <strong class="text-ocean">{{ $totalPenerima }}</strong>
                    penerima bonus

                </span>

                <span class="text-slate-500">

                    <i class="fas fa-money-bill-wave text-coral mr-1"></i>

                    Total:
                    <strong class="text-ocean">
                        Rp {{ number_format($totalBonus, 0, ',', '.') }}
                    </strong>

                </span>

            </div>

            <span class="text-xs text-slate-400">

                Dihitung:
                {{ $hasilSaws->first()?->created_at?->translatedFormat('d F Y, H:i') ?? now()->translatedFormat('d F Y') }}

            </span>

        </div>

    </div>

@endsection

@push('styles')
    <style>
        @media print {

            .no-print,
            aside,
            nav,
            header,
            footer {
                display: none !important;
            }

            main {
                padding: 0 !important;
            }

            .lg\:ml-64 {
                margin-left: 0 !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
@endpush
