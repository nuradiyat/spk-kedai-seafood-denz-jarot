{{--
================================================================
pages/kriteria/create.blade.php
Form tambah kriteria penilaian baru.
Controller : KriteriaController@create, @store
Route      : GET  /kriteria/create → kriteria.create
             POST /kriteria        → kriteria.store
================================================================
--}}
@extends('layouts.app')

@section('title', 'Tambah Kriteria')
@section('page-title', 'Tambah Kriteria')
@section('page-subtitle', 'Tambahkan kriteria penilaian SAW baru')

@section('content')

    {{-- Back + Judul --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('kriteria.index') }}"
            class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
              flex items-center justify-center hover:bg-slate-50 transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Tambah Kriteria Baru</h2>
            <p class="text-slate-400 text-sm mt-0.5">
                Sisa bobot tersedia:
                <span class="font-bold text-teal">{{ $sisaBobot ?? 100 }}%</span>
            </p>
        </div>
    </div>

    <div class="max-w-xl">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">

            <form method="POST" action="{{ route('kriteria.store') }}">
                @csrf

                {{-- Partial form --}}
                @include('pages.kriteria.partials.form')

                {{-- Tombol --}}
                {{-- Tombol aksi --}}
                <div class="flex items-center gap-3 pt-6 mt-2 border-t border-slate-100">

                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
                        text-white text-sm font-semibold px-6 py-2.5 rounded-xl
                        hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">

                        <i class="fas fa-save text-xs"></i>
                        Simpan Kriteria
                    </button>

                    <a href="{{ route('kriteria.index') }}"
                        class="text-sm text-slate-500 border border-slate-200 bg-white
                        px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">

                        Batal
                    </a>

                </div>

            </form>
        </div>
    </div>

@endsection
