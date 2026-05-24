{{--
================================================================
pages/riwayat/index.blade.php
Daftar riwayat semua periode penilaian sebagai arsip evaluasi.
Controller : RiwayatPenilaianController@index
Route      : GET /riwayat → riwayat.index
================================================================
--}}
@extends('layouts.app')

@section('title', 'Riwayat Penilaian')
@section('page-title', 'Riwayat Penilaian')
@section('page-subtitle', 'Arsip hasil penilaian semua periode sebagai bahan evaluasi')

@section('content')

    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Riwayat Penilaian</h2>
            <p class="text-slate-400 text-sm mt-0.5">{{ $riwayats->total() }} periode tersimpan</p>
        </div>
        <a href="{{ route('penilaian.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
              text-sm font-medium px-4 py-2.5 rounded-xl hover:-translate-y-0.5
              hover:shadow-md hover:shadow-ocean/25 transition-all duration-200 no-print">
            <i class="fas fa-plus text-xs"></i> Penilaian Baru
        </a>
    </div>

    {{-- ===== STAT RINGKASAN ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-ocean/10 text-ocean flex items-center justify-center">
                    <i class="fas fa-history"></i>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">Total Periode</p>
                    <p class="font-heading font-bold text-ocean text-2xl">{{ $totalPeriode ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-teal/10 text-teal-700 flex items-center justify-center">
                    <i class="fas fa-trophy"></i>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">Total Penerima</p>
                    <p class="font-heading font-bold text-ocean text-2xl">{{ $totalPenerima ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">Rata-rata Skor</p>
                    <p class="font-heading font-bold text-ocean text-2xl">{{ number_format($rataRataSkor ?? 0, 4) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== DAFTAR RIWAYAT (CARD LIST) ===== --}}
    @include('components.tables.riwayat-table')

@endsection
