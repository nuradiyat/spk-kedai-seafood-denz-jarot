{{--
================================================================
pages/riwayat/index.blade.php
Daftar riwayat semua periode penilaian sebagai arsip evaluasi.
Controller : RiwayatPenilaianController@index
Route      : GET /riwayat → riwayat.index
================================================================
--}}
@extends('layouts.app')

@section('title', 'Riwayat Penilaian')
@section('page-title', 'Riwayat Penilaian')
@section('page-subtitle', 'Arsip hasil penilaian semua periode sebagai bahan evaluasi')

@section('content')

    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Riwayat Penilaian</h2>
            <p class="text-slate-400 text-sm mt-0.5">{{ $riwayats->total() }} periode tersimpan</p>
        </div>
        <a href="{{ route('penilaian.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
              text-sm font-medium px-4 py-2.5 rounded-xl hover:-translate-y-0.5
              hover:shadow-md hover:shadow-ocean/25 transition-all duration-200 no-print">
            <i class="fas fa-plus text-xs"></i> Penilaian Baru
        </a>
    </div>

    {{-- ===== STAT RINGKASAN ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-ocean/10 text-ocean flex items-center justify-center">
                    <i class="fas fa-history"></i>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">Total Periode</p>
                    <p class="font-heading font-bold text-ocean text-2xl">{{ $totalPeriode ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-teal/10 text-teal-700 flex items-center justify-center">
                    <i class="fas fa-trophy"></i>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">Total Penerima</p>
                    <p class="font-heading font-bold text-ocean text-2xl">{{ $totalPenerima ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">Rata-rata Skor</p>
                    <p class="font-heading font-bold text-ocean text-2xl">{{ number_format($rataRataSkor ?? 0, 4) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== DAFTAR RIWAYAT (CARD LIST) ===== --}}
    <div class="space-y-3 mb-5">
        @forelse($riwayats as $i => $p)
            <a href="{{ route('riwayat.detail', $p->id) }}"
                class="flex items-center gap-4 bg-white rounded-2xl border border-slate-200
              px-5 py-4 hover:translate-x-1 hover:shadow-md hover:border-teal/30
              transition-all duration-200 group block">

                {{-- Icon periode --}}
                <div
                    class="w-12 h-12 rounded-2xl bg-teal-bg border border-teal-200
                    flex items-center justify-center text-xl shrink-0">
                    🏆</div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="font-heading font-bold text-ocean text-sm group-hover:text-ocean-lt transition-colors">
                        Penilaian Bonus — {{ $p->periode_label }}
                    </p>
                    <p class="text-slate-400 text-xs mt-0.5">
                        {{ $p->hasilSaws->count() }} karyawan dinilai
                        &bull; Penerima: <span
                            class="font-semibold text-slate-600">{{ $p->hasilSaws->where('penerima_bonus', true)->count() }}
                            orang</span>
                        &bull; Dibuat: {{ $p->created_at->translatedFormat('d M Y') }}
                    </p>
                </div>

                {{-- Stat kanan --}}
                <div class="hidden sm:flex items-center gap-4 shrink-0">
                    <div class="text-right">
                        <p class="font-heading font-bold text-ocean text-sm">
                            {{ $p->hasilSaws->where('penerima_bonus', true)->count() }}
                            <span class="text-slate-300">/{{ $p->hasilSaws->count() }}</span>
                        </p>
                        <p class="text-[10px] text-slate-400">penerima bonus</p>
                    </div>
                    @php $rank1 = $p->hasilSaws->firstWhere('ranking', 1); @endphp
                    @if ($rank1)
                        <div class="flex items-center gap-2">
                            <span
                                class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0
                             text-white text-[9px] font-bold font-heading
                             bg-gradient-to-br {{ $rank1->karyawan->warna ?? 'from-slate-400 to-slate-600' }}">
                                {{ strtoupper(substr($rank1->karyawan->nama, 0, 2)) }}
                            </span>
                            <div>
                                <p class="text-xs font-semibold text-slate-700 leading-tight">{{ $rank1->karyawan->nama }}
                                </p>
                                <p class="text-[10px] text-teal-600 font-mono">{{ number_format($rank1->nilai_akhir, 4) }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <i class="fas fa-chevron-right text-slate-300 text-xs shrink-0 group-hover:text-teal transition-colors"></i>
            </a>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 py-20 text-center">
                <i class="fas fa-history text-5xl text-slate-200 mb-4 block"></i>
                <p class="text-slate-500 font-medium">Belum ada riwayat penilaian</p>
                <p class="text-slate-400 text-sm mt-1">Selesaikan proses penilaian untuk melihat riwayat</p>
                <a href="{{ route('penilaian.create') }}"
                    class="inline-flex items-center gap-2 mt-4 text-teal text-sm font-medium hover:underline">
                    <i class="fas fa-plus text-xs"></i> Mulai penilaian
                </a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($riwayats->hasPages())
        <div class="no-print">
            {{ $riwayats->links() }}
        </div>
    @endif

@endsection
