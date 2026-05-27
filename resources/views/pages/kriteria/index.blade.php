{{--
================================================================
pages/kriteria/index.blade.php
Daftar kriteria penilaian SAW beserta bobot.
Controller: KriteriaController@index
Route: GET /kriteria → kriteria.index
================================================================
--}}
@extends('layouts.app')

@section('title', 'Kriteria & Bobot')
@section('page-title', 'Kriteria & Bobot')
@section('page-subtitle', 'Kelola kriteria penilaian dan bobot metode SAW')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Kriteria &amp; Bobot</h2>
            <p class="text-slate-400 text-sm mt-0.5">Total bobot harus berjumlah 100%</p>
        </div>
        <a href="{{ route('kriteria.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
              text-sm font-medium px-4 py-2.5 rounded-xl hover:-translate-y-0.5
              hover:shadow-md hover:shadow-ocean/25 transition-all duration-200 no-print">
            <i class="fas fa-plus text-xs"></i> Tambah Kriteria
        </a>
    </div>

    {{-- ===== TABEL KRITERIA ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-4">
        @include('components.tables.kriteria-table')
    </div>

    {{-- Total Bobot --}}
    <div
        class="bg-white rounded-2xl p-4 flex items-center justify-between
            {{ ($totalBobot ?? 0) == 100 ? 'border border-teal-200 bg-teal-bg' : 'border border-red-200 bg-red-50' }}">
        <div class="flex items-center gap-3">
            <i
                class="fas {{ ($totalBobot ?? 0) == 100 ? 'fa-check-circle text-teal' : 'fa-exclamation-circle text-red-400' }} text-lg"></i>
            <span class="text-sm font-medium {{ ($totalBobot ?? 0) == 100 ? 'text-teal-800' : 'text-red-700' }}">
                Total bobot semua kriteria
            </span>
        </div>
        <span class="font-heading font-bold text-2xl {{ ($totalBobot ?? 0) == 100 ? 'text-teal' : 'text-red-500' }}">
            {{ $totalBobot ?? 0 }}% {{ ($totalBobot ?? 0) == 100 ? '✓' : '✗' }}
        </span>
    </div>

@endsection
