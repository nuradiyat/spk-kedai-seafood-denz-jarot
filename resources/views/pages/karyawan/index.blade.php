{{--
================================================================
pages/karyawan/index.blade.php
Daftar karyawan + pencarian + pagination + CRUD actions.
Controller: KaryawanController@index
Route: GET /karyawan → karyawan.index
================================================================
--}}
@extends('layouts.app')

@section('title', 'Data Karyawan')
@section('page-title', 'Data Karyawan')
@section('page-subtitle', 'Kelola seluruh data karyawan UMKM Denz Jarot Seafood')

@section('content')

    {{-- Header aksi --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Data Karyawan</h2>
            <p class="text-slate-400 text-sm mt-0.5">
                {{ method_exists($karyawans, 'total') ? $karyawans->total() : $karyawans->count() }} karyawan terdaftar
            </p>
        </div>
        <a href="{{ route('karyawan.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
              text-sm font-medium px-4 py-2.5 rounded-xl hover:-translate-y-0.5
              hover:shadow-md hover:shadow-ocean/25 transition-all duration-200 no-print">
            <i class="fas fa-plus text-xs"></i> Tambah Karyawan
        </a>
    </div>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('karyawan.index') }}" class="flex gap-2 mb-4 no-print">
        <div
            class="flex-1 flex items-center gap-2.5 bg-white border border-slate-200
                rounded-xl px-4 focus-within:border-teal transition-colors">
            <i class="fas fa-search text-slate-400 text-sm shrink-0"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama, posisi, atau NIK..."
                class="flex-1 py-2.5 text-sm text-slate-700 outline-none bg-transparent">
        </div>
        <button type="submit"
            class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-600
                   hover:bg-slate-50 transition-colors">
            <i class="fas fa-search"></i>
        </button>
        @if (request('search'))
            <a href="{{ route('karyawan.index') }}"
                class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-400
              hover:bg-slate-50 transition-colors"
                title="Hapus filter">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </form>

    {{-- Tabel Karyawan --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-5 py-3.5">
                            No</th>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Nama Karyawan</th>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden sm:table-cell">
                            Posisi</th>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                            Tgl Masuk</th>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Status</th>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 no-print">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $i => $k)
                        <tr class="border-b border-slate-50 last:border-0 tbl-row">

                            <td class="px-5 py-3.5 text-slate-400 text-xs">
                                {{ method_exists($karyawans, 'firstItem') ? $karyawans->firstItem() + $i : $i + 1 }}
                            </td>

                            <td class="px-3 py-3.5">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0
                                         text-white text-xs font-bold font-heading
                                         bg-gradient-to-br {{ $k->warna ?? 'from-slate-400 to-slate-600' }}">
                                        {{ strtoupper(substr($k->nama, 0, 2)) }}
                                    </span>
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $k->nama }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $k->nik ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-3 py-3.5 text-slate-600 hidden sm:table-cell">{{ $k->posisi }}</td>

                            <td class="px-3 py-3.5 text-slate-500 text-xs hidden md:table-cell">
                                {{ $k->tgl_masuk ? \Carbon\Carbon::parse($k->tgl_masuk)->translatedFormat('M Y') : '—' }}
                            </td>

                            <td class="px-3 py-3.5">
                                @include('components.badges.status', ['status' => $k->status])
                            </td>

                            <td class="px-3 py-3.5 no-print">
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('karyawan.show', $k->id) }}"
                                        class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 hover:bg-slate-100
                                      flex items-center justify-center transition-colors"
                                        title="Detail">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('karyawan.edit', $k->id) }}"
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100
                                      flex items-center justify-center transition-colors"
                                        title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <button
                                        onclick="openDeleteModal('{{ route('karyawan.destroy', $k->id) }}', '{{ addslashes($k->nama) }}')"
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
                            <td colspan="6" class="py-20 text-center">
                                <i class="fas fa-users text-5xl text-slate-200 mb-4 block"></i>
                                <p class="text-slate-500 font-medium">Belum ada data karyawan</p>
                                <p class="text-slate-400 text-sm mt-1">Tambahkan karyawan untuk memulai penilaian</p>
                                <a href="{{ route('karyawan.create') }}"
                                    class="inline-flex items-center gap-2 mt-4 text-teal text-sm font-medium hover:underline">
                                    <i class="fas fa-plus text-xs"></i> Tambah karyawan pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if (method_exists($karyawans, 'hasPages') && $karyawans->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 no-print">
                {{ $karyawans->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

@endsection
