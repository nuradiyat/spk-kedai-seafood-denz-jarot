{{--
================================================================
pages/penilaian/edit.blade.php

FUNGSI  : Form edit nilai penilaian yang sudah ada.
          TIDAK ada proses SAW. Hanya update nilai mentah.
Controller : PenilaianController@edit / @update
Route      : GET /penilaian/{id}/edit → penilaian.edit
             PUT /penilaian/{id}       → penilaian.update
================================================================
--}}
@extends('layouts.app')

@section('title', 'Edit Penilaian')

@section('page-title', 'Edit Penilaian')
@section('page-subtitle',
    'Periode ' .
    \Carbon\Carbon::createFromFormat('Y-m', $penilaian->periode)->translatedFormat('F
    Y'))

@section('content')

    {{-- BREADCRUMB --}}
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-5">
        <a href="{{ route('penilaian.index') }}">Penilaian</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Edit</span>
    </nav>

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

    {{-- FORM --}}
    <form id="formEdit" method="POST" action="{{ route('penilaian.update', $penilaian->id) }}">
        @csrf
        @method('PUT')

        @include('pages.penilaian.partials.form')

        {{-- ACTION --}}
        {{-- <div class="flex justify-end gap-3 mt-6">

            <a href="{{ route('penilaian.show', $penilaian->id) }}" class="px-5 py-2.5 border rounded-xl bg-white">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-teal-600 text-white rounded-xl font-semibold">
                Simpan Perubahan
            </button>
        </div> --}}

        <div class="flex justify-end items-center gap-3 mt-6 border-t border-slate-100">

            <button type="submit"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
               text-white text-sm font-semibold px-6 py-2.5 rounded-xl
               hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">

                <i class="fas fa-save text-xs"></i>
                Simpan Perubahan
            </button>

            <a href="{{ route('penilaian.show', $penilaian->id) }}"
                class="text-sm text-slate-500 border border-slate-200 bg-white
               px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">

                Batal
            </a>

        </div>

    </form>

@endsection
