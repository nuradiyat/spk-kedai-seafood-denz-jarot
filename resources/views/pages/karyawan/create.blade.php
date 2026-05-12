{{--
================================================================
pages/karyawan/create.blade.php
Form tambah karyawan baru.
Controller: KaryawanController@create, @store
Route: GET /karyawan/create → karyawan.create
       POST /karyawan       → karyawan.store
================================================================
--}}
@extends('layouts.app')

@section('title', 'Tambah Karyawan')
@section('page-title', 'Tambah Karyawan')
@section('page-subtitle', 'Tambahkan data karyawan baru ke dalam sistem')

@section('content')

    {{-- Back button + judul --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('karyawan.index') }}"
            class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
              flex items-center justify-center hover:bg-slate-50 transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Tambah Karyawan Baru</h2>
            <p class="text-slate-400 text-sm mt-0.5">Isi formulir data karyawan di bawah ini</p>
        </div>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">

            <form method="POST" action="{{ route('karyawan.store') }}">
                @csrf

                {{-- Field form dari partial --}}
                @include('pages.karyawan.partials.form')

                {{-- Tombol aksi --}}
                <div class="flex items-center gap-3 pt-6 mt-2 border-t border-slate-100">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
                               text-white text-sm font-semibold px-6 py-2.5 rounded-xl
                               hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-save text-xs"></i> Simpan Karyawan
                    </button>
                    <a href="{{ route('karyawan.index') }}"
                        class="text-sm text-slate-500 border border-slate-200 px-5 py-2.5
                          rounded-xl hover:bg-slate-50 transition-colors">Batal</a>
                </div>

            </form>
        </div>
    </div>

@endsection
