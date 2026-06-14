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

    {{-- ================================================================
     RINGKASAN DATA BONUS
================================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-6">

        {{-- Total Data Bonus --}}
        <div
            class="bg-white rounded-xl border border-slate-200 p-4 relative overflow-hidden
               hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">

            <div class="absolute top-0 right-0 w-12 h-12 rounded-bl-[40px] bg-ocean opacity-10"></div>

            <div class="flex items-center justify-between mb-3">

                <div
                    class="w-9 h-9 rounded-lg bg-ocean/10 text-ocean
                       flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-sm"></i>
                </div>

            </div>

            <div class="font-heading font-bold text-ocean text-2xl">
                {{ $totalBonus ?? 0 }}
            </div>

            <p class="text-xs text-slate-400 mt-1">
                Total periode bonus yang tersedia.
            </p>

        </div>

        {{-- Bonus Sudah Diisi --}}
        <div
            class="bg-white rounded-xl border border-slate-200 p-4 relative overflow-hidden
               hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">

            <div class="absolute top-0 right-0 w-12 h-12 rounded-bl-[40px] bg-teal opacity-10"></div>

            <div class="flex items-center justify-between mb-3">

                <div
                    class="w-9 h-9 rounded-lg bg-teal/10 text-teal-700
                       flex items-center justify-center">
                    <i class="fas fa-check-circle text-sm"></i>
                </div>

            </div>

            <div class="font-heading font-bold text-green-600 text-2xl">
                {{ $bonusSudahDiisi ?? 0 }}
            </div>

            <p class="text-xs text-slate-400 mt-1">
                Total Bonus telah di berikan.
            </p>

        </div>

        {{-- Bonus Belum Diisi --}}
        <div
            class="bg-white rounded-xl border border-slate-200 p-4 relative overflow-hidden
               hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">

            <div class="absolute top-0 right-0 w-12 h-12 rounded-bl-[40px] bg-coral opacity-10"></div>

            <div class="flex items-center justify-between mb-3">

                <div
                    class="w-9 h-9 rounded-lg bg-coral/10 text-coral
                       flex items-center justify-center">
                    <i class="fas fa-clock text-sm"></i>
                </div>

            </div>

            <div class="font-heading font-bold text-coral text-2xl">
                {{ $bonusBelumDiisi ?? 0 }}
            </div>

            <p class="text-xs text-slate-400 mt-1">
                Menunggu pengisian total bonus.
            </p>

        </div>

    </div>

    </form>

    {{-- TABEL KARYAWAN --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        @include('components.tables.bonus-table')

    </div>

@endsection
