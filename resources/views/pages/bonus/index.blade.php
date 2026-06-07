{{--
================================================================
pages/bonus/index.blade.php
Daftar bonus + pagination + CRUD actions.
Controller: BonusController@index
Route: GET /bonus → bonus.index
================================================================
--}}

@extends('layouts.app')

@section('title', 'Data Bonus - SPK Bonus Karyawan')
@section('page-title', 'Data Bonus')
@section('page-subtitle', 'Kelola data bonus karyawan')

@section('content')

    {{-- HEADER AKSI --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">

        <div>

            <h2 class="font-heading font-bold text-ocean text-xl">
                Data Bonus
            </h2>

            <p class="text-slate-400 text-sm mt-0.5">
                {{ $bonuses->total() }} bonus terdaftar
            </p>

        </div>

    </div>

        <button type="submit"
            class="px-4 py-2.5
                   bg-white border border-slate-200
                   rounded-xl text-sm text-slate-600
                   hover:bg-slate-50 transition-colors">

            <i class="fas fa-search"></i>

        </button>

        @if (request('search'))
            <a href="{{ route('bonus.index') }}"
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

        @include('components.tables.bonus-table')

    </div>

@endsection
