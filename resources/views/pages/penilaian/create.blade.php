{{--
================================================================
pages/penilaian/create.blade.php

FUNGSI  : Form tambah penilaian baru — input nilai karyawan.
          TIDAK ada proses SAW. Hanya menyimpan nilai mentah (X).
Controller : PenilaianController@create / @store
Route      : GET  /penilaian/create → penilaian.create
             POST /penilaian        → penilaian.store
================================================================
--}}
@extends('layouts.app')

@section('title', 'Tambah Penilaian')
@section('page-title', 'Tambah Penilaian')
@section('page-subtitle', 'Input nilai karyawan per kriteria')

@section('content')

    <form id="formPenilaian" method="POST" action="{{ route('penilaian.store') }}">
        @csrf

        {{-- FORM PARTIAL --}}
        @include('pages.penilaian.partials.form')

        {{-- ACTION BUTTON --}}
        {{-- <div class="flex justify-end gap-3 mt-6">
        <a href="{{ route('penilaian.index') }}"
           class="px-5 py-2.5 rounded-xl border bg-white text-slate-600">
            Batal
        </a>

        <button type="submit"
            class="px-6 py-2.5 rounded-xl bg-teal-600 text-white font-semibold">
            Simpan Penilaian
        </button>
    </div> --}}

        <div class="flex justify-end items-center gap-3 mt-6 border-t border-slate-100">

            <button type="submit"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
               text-white text-sm font-semibold px-6 py-2.5 rounded-xl
               hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">

                <i class="fas fa-save text-xs"></i>
                Simpan Penilaian
            </button>

            <a href="{{ route('penilaian.index') }}"
                class="text-sm text-slate-500 border border-slate-200 bg-white
               px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">

                Batal
            </a>

        </div>

    </form>

@endsection
