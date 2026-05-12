{{--
================================================================
pages/penilaian/index.blade.php
Daftar semua periode penilaian karyawan.
Controller : PenilaianController@index
Route      : GET /penilaian → penilaian.index
================================================================
--}}
@extends('layouts.app')

@section('title', 'Input Penilaian')
@section('page-title', 'Input Penilaian')
@section('page-subtitle', 'Kelola data nilai karyawan per periode')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Daftar Penilaian</h2>
            <p class="text-slate-400 text-sm mt-0.5">{{ $penilaians->total() }} periode penilaian</p>
        </div>
        <a href="{{ route('penilaian.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
              text-sm font-medium px-4 py-2.5 rounded-xl hover:-translate-y-0.5
              hover:shadow-md hover:shadow-ocean/25 transition-all duration-200">
            <i class="fas fa-plus text-xs"></i> Penilaian Baru
        </a>
    </div>

    {{-- Tabel Penilaian --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-5 py-3.5">
                            No</th>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Periode</th>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden sm:table-cell">
                            Judul</th>
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                            Karyawan Dinilai</th>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Status</th>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                            Dibuat Oleh</th>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penilaians as $i => $p)
                        <tr class="border-b border-slate-50 last:border-0 tbl-row">

                            <td class="px-5 py-3.5 text-slate-400 text-xs">
                                {{ $penilaians->firstItem() + $i }}
                            </td>

                            <td class="px-3 py-3.5">
                                <div class="font-heading font-bold text-ocean text-sm">{{ $p->periode_label }}</div>
                                <div class="text-[11px] text-slate-400">{{ $p->periode }}</div>
                            </td>

                            <td class="px-3 py-3.5 text-slate-600 hidden sm:table-cell max-w-[200px] truncate">
                                {{ $p->judul }}
                            </td>

                            <td class="px-3 py-3.5 text-center hidden md:table-cell">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                     bg-ocean/10 text-ocean font-heading font-bold text-sm">
                                    {{ $p->total_karyawan }}
                                </span>
                            </td>

                            <td class="px-3 py-3.5">
                                @include('components.badges.status', ['status' => $p->status])
                            </td>

                            <td class="px-3 py-3.5 text-slate-500 text-xs hidden md:table-cell">
                                {{ $p->creator->name ?? '—' }}
                                <br>
                                <span class="text-slate-400">{{ $p->created_at->translatedFormat('d M Y') }}</span>
                            </td>

                            <td class="px-3 py-3.5">
                                <div class="flex items-center gap-1.5">

                                    {{-- Lihat Detail --}}
                                    <a href="{{ route('penilaian.show', $p->id) }}"
                                        class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 hover:bg-slate-100
                                      flex items-center justify-center transition-colors"
                                        title="Detail">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>

                                    {{-- Edit (hanya draft) --}}
                                    @if ($p->status === 'draft')
                                        <a href="{{ route('penilaian.edit', $p->id) }}"
                                            class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100
                                      flex items-center justify-center transition-colors"
                                            title="Edit Nilai">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>
                                    @endif

                                    {{-- Proses SAW --}}
                                    <form method="POST" action="{{ route('hasil.proses', $p->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-teal-bg text-teal-700 hover:bg-teal-100
                                               flex items-center justify-center transition-colors"
                                            title="Proses SAW"
                                            onclick="return confirm('Proses perhitungan SAW untuk periode ini?')">
                                            <i class="fas fa-calculator text-xs"></i>
                                        </button>
                                    </form>

                                    {{-- Hapus --}}
                                    <button
                                        onclick="openDeleteModal('{{ route('penilaian.destroy', $p->id) }}','{{ $p->periode_label }}')"
                                        class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100
                                           flex items-center justify-center transition-colors"
                                        title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <i class="fas fa-star text-5xl text-slate-200 mb-4 block"></i>
                                <p class="text-slate-500 font-medium">Belum ada data penilaian</p>
                                <p class="text-slate-400 text-sm mt-1">Mulai input nilai karyawan untuk periode berjalan</p>
                                <a href="{{ route('penilaian.create') }}"
                                    class="inline-flex items-center gap-2 mt-4 text-teal text-sm font-medium hover:underline">
                                    <i class="fas fa-plus text-xs"></i> Buat penilaian pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($penilaians->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $penilaians->links() }}
            </div>
        @endif
    </div>

@endsection
