{{--
================================================================
pages/hasil/index.blade.php
Daftar semua periode yang sudah selesai dihitung SAW-nya.
Controller : HasilSawController@index
Route      : GET /hasil → hasil.index
================================================================
--}}
@extends('layouts.app')

@section('title', 'Hasil & Ranking SAW')
@section('page-title', 'Hasil & Ranking')
@section('page-subtitle', 'Daftar hasil perhitungan SAW per periode')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Hasil &amp; Ranking SAW</h2>
            <p class="text-slate-400 text-sm mt-0.5">
                {{ $hasilList->total() }} periode perhitungan SAW tersedia
            </p>
        </div>
        <a href="{{ route('penilaian.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
              text-sm font-medium px-4 py-2.5 rounded-xl hover:-translate-y-0.5
              hover:shadow-md hover:shadow-ocean/25 transition-all duration-200">
            <i class="fas fa-plus text-xs"></i> Penilaian Baru
        </a>
    </div>

    {{-- Tabel hasil --}}
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
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden sm:table-cell">
                            Karyawan</th>
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                            Penerima Bonus</th>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                            Peringkat 1</th>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden lg:table-cell">
                            Tanggal</th>
                        <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasilList as $i => $p)
                        @php $rank1 = $p->hasilSaws->where('ranking', 1)->first(); @endphp
                        <tr class="border-b border-slate-50 last:border-0 tbl-row">

                            <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $hasilList->firstItem() + $i }}</td>

                            <td class="px-3 py-3.5">
                                <div class="font-heading font-bold text-ocean text-sm">{{ $p->periode_label }}</div>
                                <div class="text-[11px] text-slate-400">{{ $p->judul }}</div>
                            </td>

                            <td class="px-3 py-3.5 text-center hidden sm:table-cell">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                     bg-ocean/10 text-ocean font-heading font-bold text-sm">
                                    {{ $p->hasil_saws_count }}
                                </span>
                            </td>

                            <td class="px-3 py-3.5 text-center hidden md:table-cell">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                     bg-teal-bg text-teal-700 font-heading font-bold text-sm border border-teal-200">
                                    {{ $p->hasilSaws->where('penerima_bonus', true)->count() }}
                                </span>
                            </td>

                            <td class="px-3 py-3.5 hidden md:table-cell">
                                @if ($rank1)
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 rounded-lg flex items-center justify-center shrink-0
                                         text-white text-[9px] font-bold font-heading
                                         bg-gradient-to-br {{ $rank1->karyawan->warna ?? 'from-slate-400 to-slate-600' }}">
                                            {{ strtoupper(substr($rank1->karyawan->nama, 0, 2)) }}
                                        </span>
                                        <div>
                                            <p class="font-semibold text-slate-800 text-xs">{{ $rank1->karyawan->nama }}</p>
                                            <p class="text-[10px] text-teal-600 font-mono">
                                                {{ number_format($rank1->nilai_akhir, 4) }}</p>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>

                            <td class="px-3 py-3.5 text-slate-500 text-xs hidden lg:table-cell">
                                {{ $p->created_at->translatedFormat('d M Y') }}
                            </td>

                            <td class="px-3 py-3.5">
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('hasil.detail', $p->id) }}"
                                        class="w-8 h-8 rounded-lg bg-ocean/10 text-ocean hover:bg-ocean/20
                                      flex items-center justify-center transition-colors"
                                        title="Detail">
                                        <i class="fas fa-trophy text-xs"></i>
                                    </a>
                                    <button onclick="openExportModal()"
                                        class="w-8 h-8 rounded-lg bg-teal-bg text-teal-700 hover:bg-teal-100
                                           flex items-center justify-center transition-colors"
                                        title="Export">
                                        <i class="fas fa-download text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <i class="fas fa-trophy text-5xl text-slate-200 mb-4 block"></i>
                                <p class="text-slate-500 font-medium">Belum ada hasil perhitungan SAW</p>
                                <p class="text-slate-400 text-sm mt-1">Proses penilaian terlebih dahulu</p>
                                <a href="{{ route('penilaian.index') }}"
                                    class="inline-flex items-center gap-2 mt-4 text-teal text-sm font-medium hover:underline">
                                    <i class="fas fa-star text-xs"></i> Input Penilaian
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($hasilList->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $hasilList->links() }}
            </div>
        @endif
    </div>

@endsection
