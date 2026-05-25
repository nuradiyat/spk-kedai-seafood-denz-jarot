{{--
================================================================
pages/karyawan/index.blade.php
Daftar karyawan + pencarian + pagination + CRUD actions.
Controller: KaryawanController@index
Route: GET /karyawan → karyawan.index
================================================================
--}}

@extends('layouts.app')

@section('title', 'Data Karyawan')
@section('page-title', 'Data Karyawan')
@section('page-subtitle', 'Kelola seluruh data karyawan UMKM Denz Jarot Seafood')

@section('content')

    {{-- HEADER AKSI --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">

        <div>

            <h2 class="font-heading font-bold text-ocean text-xl">
                Data Karyawan
            </h2>

            <p class="text-slate-400 text-sm mt-0.5">
                {{ $karyawans->total() }} karyawan terdaftar
            </p>

        </div>

        <a href="{{ route('karyawan.create') }}"
            class="inline-flex items-center gap-2
              bg-gradient-to-r from-ocean to-ocean-lt
              text-white text-sm font-medium
              px-4 py-2.5 rounded-xl
              hover:-translate-y-0.5
              hover:shadow-md hover:shadow-ocean/25
              transition-all duration-200 no-print">

            <i class="fas fa-plus text-xs"></i>

            Tambah Karyawan

        </a>

    </div>

    {{-- FORM PENCARIAN --}}
    <form method="GET" action="{{ route('karyawan.index') }}" class="flex gap-2 mb-4 no-print">

        <div
            class="flex-1 flex items-center gap-2.5
                bg-white border border-slate-200
                rounded-xl px-4
                focus-within:border-teal transition-colors">

            <i class="fas fa-search text-slate-400 text-sm shrink-0"></i>

            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama, posisi, atau NIK..."
                class="flex-1 py-2.5 text-sm
                      text-slate-700 outline-none
                      bg-transparent">

        </div>

        <button type="submit"
            class="px-4 py-2.5
                   bg-white border border-slate-200
                   rounded-xl text-sm text-slate-600
                   hover:bg-slate-50 transition-colors">

            <i class="fas fa-search"></i>

        </button>

        @if (request('search'))
            <a href="{{ route('karyawan.index') }}"
                class="px-4 py-2.5
                  bg-white border border-slate-200
                  rounded-xl text-sm text-slate-400
                  hover:bg-slate-50 transition-colors"
                title="Hapus pencarian">

                <i class="fas fa-times"></i>

            </a>
        @endif

    </form>

    {{-- TABEL KARYAWAN --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        @include('components.tables.karyawan-table')

    </div>

@endsection
