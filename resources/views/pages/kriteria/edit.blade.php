{{--
================================================================
pages/kriteria/edit.blade.php
Form edit kriteria penilaian.
Controller : KriteriaController@edit, @update
Route      : GET /kriteria/{id}/edit → kriteria.edit
             PUT /kriteria/{id}       → kriteria.update
================================================================
--}}
@extends('layouts.app')

@section('title', 'Edit Kriteria — ' . $kriteria->kode)
@section('page-title', 'Edit Kriteria')
@section('page-subtitle', 'Ubah kriteria — ' . $kriteria->kode . ' : ' . $kriteria->nama)

@section('content')

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('kriteria.index') }}"
            class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
              flex items-center justify-center hover:bg-slate-50 transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Edit Kriteria</h2>
            <p class="text-slate-400 text-sm mt-0.5">{{ $kriteria->kode }} — {{ $kriteria->nama }}</p>
        </div>
    </div>

    <div class="max-w-xl">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">

            <form method="POST" action="{{ route('kriteria.update', $kriteria->id) }}">
                @csrf
                @method('PUT')

                {{-- Partial form dengan data kriteria --}}
                @include('pages.kriteria.partials.form', ['kriteria' => $kriteria])

                <div class="flex items-center gap-3 pt-6 mt-2 border-t border-slate-100">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
                               text-white text-sm font-semibold px-6 py-2.5 rounded-xl
                               hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-save text-xs"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('kriteria.index') }}"
                        class="text-sm text-slate-500 border border-slate-200 px-5 py-2.5
                          rounded-xl hover:bg-slate-50 transition-colors">Batal</a>
                </div>

            </form>
        </div>
    </div>

@endsection
