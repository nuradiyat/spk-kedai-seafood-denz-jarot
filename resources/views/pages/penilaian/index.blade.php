{{--
================================================================
pages/penilaian/index.blade.php
Daftar semua periode penilaian karyawan.
Controller : PenilaianController@index
Route      : GET /penilaian → penilaian.index
================================================================
--}}

@extends('layouts.app')

@section('title', 'Data Penilaian')
@section('page-title', 'Input Penilaian')
@section('page-subtitle', 'Kelola data penilaian karyawan')

@section('content')

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">

        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">
                Data Penilaian
            </h2>

            <p class="text-slate-400 text-sm mt-1">
                {{ $penilaians->total() }} periode penilaian tersedia
            </p>
        </div>

        <a href="{{ route('penilaian.create') }}"
            class="inline-flex items-center gap-2
                   bg-gradient-to-r from-ocean to-ocean-lt
                   text-white text-sm font-medium
                   px-4 py-2.5 rounded-xl
                   hover:-translate-y-0.5
                   hover:shadow-md hover:shadow-ocean/25
                   transition-all duration-200">

            <i class="fas fa-plus text-xs"></i>

            Tambah Penilaian

        </a>

    </div>

    {{-- INFO --}}
    <div
        class="flex items-start gap-3
                bg-blue-50 border border-blue-200
                rounded-2xl px-5 py-4 mb-6">

        <div class="w-8 h-8 rounded-lg bg-blue-100
                    flex items-center justify-center shrink-0">

            <i class="fas fa-info-circle text-blue-500 text-sm"></i>

        </div>

        <div>

            <p class="text-sm font-semibold text-blue-800 mb-1">
                Informasi
            </p>

            <p class="text-xs text-blue-600 leading-relaxed">
                Halaman ini digunakan untuk mengelola data penilaian karyawan.
                Proses perhitungan metode SAW dilakukan pada menu Perhitungan SAW,
                sedangkan hasil akhir perankingan ditampilkan pada menu
                <strong>Hasil & Ranking</strong>.
            </p>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        @include('components.tables.penilaian-table')

    </div>

@endsection
