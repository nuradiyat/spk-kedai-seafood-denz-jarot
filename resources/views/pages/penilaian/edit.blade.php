{{--
================================================================
pages/penilaian/edit.blade.php

FUNGSI  : Form edit penilaian — input nilai karyawan.
          TIDAK ada proses SAW. Hanya menyimpan nilai mentah (X).
Controller : PenilaianController@edit / @update
Route      : GET  /penilaian/{penilaian}/edit → penilaian.edit
             PUT  /penilaian/{penilaian}        → penilaian.update
================================================================
--}}
@extends('layouts.app')

@section('title', 'Edit Penilaian')
@section('page-title', 'Edit Penilaian')
@section('page-subtitle', 'Input nilai karyawan per kriteria')

@section('content')

    {{-- Back button + judul --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('karyawan.index') }}"
            class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
              flex items-center justify-center hover:bg-slate-50 transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Edit penilaian Karyawan</h2>
            <p class="text-slate-400 text-sm mt-0.5">Perbarui penilaian karyawan di bawah ini</p>
        </div>
    </div>

    {{-- WARNING --}}
    @if ($penilaian->hasilSaws->count() > 0)
        <div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 mb-6">
            <p class="font-semibold text-amber-800">
                Data sudah memiliki hasil SAW
            </p>
            <p class="text-sm text-amber-700 mt-1">
                Perubahan nilai akan membuat hasil ranking perlu dihitung ulang.
            </p>
        </div>
    @endif

    <form id="formPenilaian" method="POST" action="{{ route('penilaian.update', $penilaian->id) }}">
        @csrf
        @method('PUT')

        {{-- FORM PARTIAL --}}
        @include('pages.penilaian.partials.form')

        <div class="flex justify-end items-center gap-3 mt-6 border-t border-slate-100">

            <button type="submit"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
               text-white text-sm font-semibold px-6 py-2.5 rounded-xl
               hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">

                <i class="fas fa-save text-xs"></i>
                Simpan Perubahan
            </button>

            <a href="{{ route('penilaian.index') }}"
                class="text-sm text-slate-500 border border-slate-200 bg-white
               px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">

                Batal
            </a>

        </div>

    </form>

@endsection
