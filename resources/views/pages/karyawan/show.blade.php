{{--
================================================================
pages/karyawan/show.blade.php
Detail informasi karyawan + riwayat nilai SAW.
Controller: KaryawanController@show
Route: GET /karyawan/{id} → karyawan.show
================================================================
--}}
@extends('layouts.app')

@section('title', 'Detail — ' . $karyawan->nama)
@section('page-title', 'Detail Karyawan')
@section('page-subtitle', $karyawan->nama . ' — ' . $karyawan->posisi)

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('karyawan.index') }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <h2 class="font-heading font-bold text-ocean text-xl">Detail Karyawan</h2>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('karyawan.edit', $karyawan->id) }}"
                class="inline-flex items-center gap-2 border border-slate-200 bg-white text-slate-600
                  text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                <i class="fas fa-pen text-xs"></i> Edit
            </a>
            <button
                onclick="openDeleteModal('{{ route('karyawan.destroy', $karyawan->id) }}','{{ addslashes($karyawan->nama) }}')"
                class="inline-flex items-center gap-2 bg-red-50 text-red-500 border border-red-200
                       text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-red-100 transition-colors">
                <i class="fas fa-trash text-xs"></i> Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Kartu Profil --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col items-center text-center">
            <div
                class="w-20 h-20 rounded-2xl flex items-center justify-center font-heading font-bold text-white text-3xl mb-4
                    bg-gradient-to-br {{ $karyawan->warna ?? 'from-slate-400 to-slate-600' }}">
                {{ strtoupper(substr($karyawan->nama, 0, 2)) }}
            </div>
            <h3 class="font-heading font-bold text-ocean text-lg leading-tight">{{ $karyawan->nama }}</h3>
            <p class="text-slate-400 text-sm mt-1 mb-3">{{ $karyawan->posisi }}</p>
            @include('components.badges.status', ['status' => $karyawan->status])
            <p class="text-[11px] text-slate-400 mt-4">
                Bergabung:
                {{ $karyawan->tgl_masuk ? \Carbon\Carbon::parse($karyawan->tgl_masuk)->translatedFormat('d F Y') : '—' }}
            </p>
        </div>

        {{-- Info Detail --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-6">
            <h3 class="font-heading font-bold text-ocean text-[15px] mb-5">Informasi Lengkap</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ([['NIK', $karyawan->nik ?? '—', 'fa-id-card'], ['Posisi', $karyawan->posisi, 'fa-briefcase'], ['Tanggal Masuk', $karyawan->tgl_masuk ? \Carbon\Carbon::parse($karyawan->tgl_masuk)->translatedFormat('d F Y') : '—', 'fa-calendar-alt'], ['No. HP', $karyawan->no_hp ?? '—', 'fa-phone'], ['Status', ucfirst(str_replace('_', ' ', $karyawan->status)), 'fa-toggle-on'], ['Alamat', $karyawan->alamat ?? '—', 'fa-map-marker-alt']] as [$lbl, $val, $icon])
                    <div class="flex items-start gap-3 p-3.5 bg-slate-50 rounded-xl">
                        <div
                            class="w-8 h-8 rounded-lg bg-white border border-slate-200
                            flex items-center justify-center text-slate-400 text-xs shrink-0 mt-0.5">
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">{{ $lbl }}
                            </p>
                            <p class="text-sm font-medium text-slate-800 mt-0.5 break-words">{{ $val }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Riwayat Nilai SAW --}}
    @if (isset($riwayatNilai) && $riwayatNilai->count())
        <div class="mt-5 bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-heading font-bold text-ocean text-[15px]">Riwayat Nilai SAW</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th
                                class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-5 py-3">
                                Periode</th>
                            @foreach ($kriterias ?? [] as $k)
                                <th
                                    class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3">
                                    {{ $k->kode }}
                                </th>
                            @endforeach
                            <th
                                class="text-center text-[11px] font-semibold text-teal-600 uppercase tracking-wide px-3 py-3">
                                V<sub>i</sub></th>
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3">
                                Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatNilai as $rn)
                            <tr class="border-b border-slate-50 last:border-0 tbl-row">
                                <td class="px-5 py-3 font-medium text-slate-800 text-sm">{{ $rn->periode_label }}</td>
                                @foreach ($kriterias ?? [] as $k)
                                    <td class="px-3 py-3 text-center text-slate-600">
                                        {{ $rn->nilai[$k->id] ?? '—' }}
                                    </td>
                                @endforeach
                                <td class="px-3 py-3 text-center font-bold text-teal-600">
                                    {{ number_format($rn->vi, 4) }}
                                </td>
                                <td class="px-3 py-3 text-center">
                                    @include('components.badges.ranking', ['rank' => $rn->rank])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection
