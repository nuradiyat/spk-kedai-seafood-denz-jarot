{{--
================================================================
pages/karyawan/show.blade.php
Detail informasi karyawan + riwayat nilai SAW.
Controller: KaryawanController@show
Route: GET /karyawan/{id} → karyawan.show
================================================================
--}}

@extends('layouts.app')

@section('title', 'Detail ' . $karyawan->nama_karyawan)
@section('page-title', 'Detail Karyawan')
@section('page-subtitle', $karyawan->nama_karyawan . ' — ' . ($karyawan->jabatan ?? '-'))

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('karyawan.index') }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>

            <h2 class="font-heading font-bold text-ocean text-xl">
                Detail Karyawan
            </h2>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('karyawan.edit', $karyawan->id) }}"
                class="inline-flex items-center gap-2 border border-slate-200 bg-white text-slate-600
                text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                <i class="fas fa-pen text-xs"></i>
                Edit
            </a>

            <button
                onclick="openDeleteModal('{{ route('karyawan.destroy', $karyawan->id) }}','{{ addslashes($karyawan->nama_karyawan) }}')"
                class="inline-flex items-center gap-2 bg-red-50 text-red-500 border border-red-200
                text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-red-100 transition-colors">
                <i class="fas fa-trash text-xs"></i>
                Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Profil --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col items-center text-center">

            <div
                class="w-20 h-20 rounded-2xl flex items-center justify-center 
                font-heading font-bold text-white text-3xl mb-4
                bg-gradient-to-br from-sky-500 to-cyan-600">
                {{ strtoupper(substr($karyawan->nama_karyawan, 0, 2)) }}
            </div>

            <h3 class="font-heading font-bold text-ocean text-lg leading-tight">
                {{ $karyawan->nama_karyawan }}
            </h3>

            <p class="text-slate-400 text-sm mt-1 mb-3">
                {{ $karyawan->jabatan ?? '-' }}
            </p>

            @include('components.badges.status', [
                'status' => $karyawan->status,
            ])

            <p class="text-[11px] text-slate-400 mt-4">
                Bergabung:
                {{ $karyawan->tanggal_masuk ? \Carbon\Carbon::parse($karyawan->tanggal_masuk)->translatedFormat('d F Y') : '—' }}
            </p>
        </div>

        {{-- Informasi Detail --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-6">

            <h3 class="font-heading font-bold text-ocean text-[15px] mb-5">
                Informasi Lengkap
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                @foreach ([['Nama Karyawan', $karyawan->nama_karyawan, 'fa-user'], ['Jabatan', $karyawan->jabatan ?? '—', 'fa-briefcase'], ['Tanggal Masuk', $karyawan->tanggal_masuk ? \Carbon\Carbon::parse($karyawan->tanggal_masuk)->translatedFormat('d F Y') : '—', 'fa-calendar-alt'], ['Status', ucfirst($karyawan->status), 'fa-toggle-on']] as [$label, $value, $icon])
                    <div class="flex items-start gap-3 p-3.5 bg-slate-50 rounded-xl">

                        <div
                            class="w-8 h-8 rounded-lg bg-white border border-slate-200
                            flex items-center justify-center text-slate-400 text-xs shrink-0 mt-0.5">
                            <i class="fas {{ $icon }}"></i>
                        </div>

                        <div class="min-w-0">
                            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">
                                {{ $label }}
                            </p>

                            <p class="text-sm font-medium text-slate-800 mt-0.5 break-words">
                                {{ $value }}
                            </p>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>

    </div>

@endsection
