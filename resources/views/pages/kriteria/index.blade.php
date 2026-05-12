{{--
================================================================
pages/kriteria/index.blade.php
Daftar kriteria penilaian SAW beserta bobot.
Controller: KriteriaController@index
Route: GET /kriteria → kriteria.index
================================================================
--}}
@extends('layouts.app')

@section('title', 'Kriteria & Bobot')
@section('page-title', 'Kriteria & Bobot')
@section('page-subtitle', 'Kelola kriteria penilaian dan bobot metode SAW')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Kriteria &amp; Bobot</h2>
            <p class="text-slate-400 text-sm mt-0.5">Total bobot harus berjumlah 100%</p>
        </div>
        <a href="{{ route('kriteria.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
              text-sm font-medium px-4 py-2.5 rounded-xl hover:-translate-y-0.5
              hover:shadow-md hover:shadow-ocean/25 transition-all duration-200 no-print">
            <i class="fas fa-plus text-xs"></i> Tambah Kriteria
        </a>
    </div>

    {{-- Tabel Kriteria --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-4">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-5 py-3.5">
                            Kode</th>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Nama Kriteria</th>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Tipe</th>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Bobot</th>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 min-w-[140px] hidden md:table-cell">
                            Visual</th>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 no-print">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $barColors = ['bg-blue-400', 'bg-teal', 'bg-amber-400', 'bg-coral', 'bg-purple-400'];
                    @endphp
                    @forelse($kriterias as $idx => $k)
                        <tr class="border-b border-slate-50 last:border-0 tbl-row">
                            <td class="px-5 py-4">
                                <span class="font-heading font-bold text-ocean text-xs bg-slate-100 px-2.5 py-1 rounded-lg">
                                    {{ $k->kode }}
                                </span>
                            </td>
                            <td class="px-3 py-4">
                                <p class="font-semibold text-slate-800">{{ $k->nama }}</p>
                                @if ($k->deskripsi)
                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $k->deskripsi }}</p>
                                @endif
                            </td>
                            <td class="px-3 py-4">
                                @include('components.badges.status', ['status' => $k->tipe])
                            </td>
                            <td class="px-3 py-4">
                                <span class="font-bold text-ocean text-base">{{ $k->bobot * 100 }}%</span>
                            </td>
                            <td class="px-3 py-4 hidden md:table-cell">
                                <div class="flex items-center gap-2.5">
                                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full bar {{ $barColors[$idx % 5] }}"
                                            style="width:{{ $k->bobot * 100 }}%"></div>
                                    </div>
                                    <span class="text-xs text-slate-400 min-w-[36px]">{{ $k->bobot * 100 }}%</span>
                                </div>
                            </td>
                            <td class="px-3 py-4 no-print">
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('kriteria.edit', $k->id) }}"
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100
                                      flex items-center justify-center transition-colors">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <button
                                        onclick="openDeleteModal('{{ route('kriteria.destroy', $k->id) }}','{{ $k->kode }} — {{ addslashes($k->nama) }}')"
                                        class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100
                                           flex items-center justify-center transition-colors">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <i class="fas fa-sliders-h text-5xl text-slate-200 mb-3 block"></i>
                                <p class="text-slate-400 text-sm">Belum ada kriteria penilaian</p>
                                <a href="{{ route('kriteria.create') }}"
                                    class="text-teal text-sm font-medium mt-2 inline-block hover:underline">
                                    + Tambah kriteria
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Total Bobot --}}
    <div
        class="bg-white rounded-2xl p-4 flex items-center justify-between
            {{ ($totalBobot ?? 0) == 100 ? 'border border-teal-200 bg-teal-bg' : 'border border-red-200 bg-red-50' }}">
        <div class="flex items-center gap-3">
            <i
                class="fas {{ ($totalBobot ?? 0) == 100 ? 'fa-check-circle text-teal' : 'fa-exclamation-circle text-red-400' }} text-lg"></i>
            <span class="text-sm font-medium {{ ($totalBobot ?? 0) == 100 ? 'text-teal-800' : 'text-red-700' }}">
                Total bobot semua kriteria
            </span>
        </div>
        <span class="font-heading font-bold text-2xl {{ ($totalBobot ?? 0) == 100 ? 'text-teal' : 'text-red-500' }}">
            {{ $totalBobot ?? 0 }}% {{ ($totalBobot ?? 0) == 100 ? '✓' : '✗' }}
        </span>
    </div>

@endsection
