{{--
================================================================
pages/karyawan/edit.blade.php
Form edit data karyawan.
Controller: KaryawanController@edit, @update
Route: GET /karyawan/{id}/edit → karyawan.edit
       PUT /karyawan/{id}       → karyawan.update
================================================================
--}}
@extends('layouts.app')

@section('title', 'Edit Karyawan — ' . $karyawan->nama)
@section('page-title', 'Edit Karyawan')
@section('page-subtitle', 'Ubah data karyawan — ' . $karyawan->nama)

@section('content')

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('karyawan.index') }}"
            class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
              flex items-center justify-center hover:bg-slate-50 transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Edit Karyawan</h2>
            <p class="text-slate-400 text-sm mt-0.5">{{ $karyawan->nama }}</p>
        </div>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">

            <form method="POST" action="{{ route('karyawan.update', $karyawan->id) }}">
                @csrf
                @method('PUT')

                {{-- Field form dari partial dengan data karyawan --}}
                @include('pages.karyawan.partials.form', ['karyawan' => $karyawan])

                {{-- Tombol aksi --}}
                <div class="flex items-center gap-3 pt-6 mt-2 border-t border-slate-100">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
                               text-white text-sm font-semibold px-6 py-2.5 rounded-xl
                               hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-save text-xs"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('karyawan.index') }}"
                        class="text-sm text-slate-500 border border-slate-200 px-5 py-2.5
                          rounded-xl hover:bg-slate-50 transition-colors">Batal</a>
                </div>

            </form>
        </div>
    </div>

@endsection
