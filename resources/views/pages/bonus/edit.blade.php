{{--
================================================================
pages/bonus/edit.blade.php
Form edit data karyawan.
Controller: BonusController@edit, @update
================================================================
--}}
@extends('layouts.app')

@section('title', 'Edit Bonus')
@section('page-title', 'Edit Bonus')
@section('page-subtitle', 'Ubah total bonus untuk periode penilaian')

@section('content')

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-5">

        <a href="{{ route('bonus.index') }}"
            class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                   flex items-center justify-center hover:bg-slate-50 transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">
                Edit Bonus
            </h2>

            <p class="text-slate-400 text-sm mt-0.5">
                Periode {{ $bonus->periode_label }}
            </p>
        </div>

    </div>

    {{-- update bonus  --}}
    <form method="POST" action="{{ route('bonus.update', $bonus->id) }}">
        @csrf
        @method('PUT')

        @include('pages.bonus.partials.form')

        <div class="flex items-center gap-3 pt-6 mt-5 border-t border-slate-100">

            <button type="submit"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
            text-white text-sm font-semibold px-6 py-2.5 rounded-xl
            hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">

                <i class="fas fa-save text-xs"></i>
                Simpan Perubahan

            </button>

            <a href="{{ route('bonus.index') }}"
                class="text-sm text-slate-500 border border-slate-200 px-5 py-2.5
            rounded-xl hover:bg-slate-50 transition-colors">

                Batal

            </a>

        </div>

    </form>

@endsection
