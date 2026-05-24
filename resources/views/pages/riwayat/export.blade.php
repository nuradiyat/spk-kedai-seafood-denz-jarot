{{--
================================================================
pages/riwayat/export.blade.php
Export / cetak laporan riwayat satu periode.
Controller : RiwayatPenilaianController@export
Route      : GET /riwayat/{penilaian}/export → riwayat.export
================================================================
--}}
@extends('layouts.app')

@section('title', 'Export Riwayat — ' . $penilaian->periode_label)
@section('page-title', 'Export Riwayat')
@section('page-subtitle', 'Cetak / unduh laporan riwayat penilaian ' . $penilaian->periode_label)

@section('content')

    {{-- ===== TOOLBAR (tidak ikut cetak) ===== --}}
    <div class="flex items-center justify-between mb-5 no-print">
        <div class="flex items-center gap-3">
            <a href="{{ route('riwayat.detail', $penilaian->id) }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-heading font-bold text-ocean text-xl">Export Riwayat</h2>
                <p class="text-slate-400 text-sm mt-0.5">{{ $penilaian->periode_label }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="?format=pdf"
                class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white
                  text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <i class="fas fa-file-pdf text-xs"></i> PDF
            </a>
            <a href="?format=excel"
                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white
                  text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <i class="fas fa-file-excel text-xs"></i> Excel
            </a>
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 bg-slate-700 hover:bg-slate-800 text-white
                       text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <i class="fas fa-print text-xs"></i> Print
            </button>
        </div>
    </div>

    {{-- ===== DOKUMEN ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        {{-- Kop --}}
        <div class="bg-gradient-to-r from-ocean to-ocean-lt px-8 py-6 text-white">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center text-2xl shrink-0">🐟</div>
                <div>
                    <h1 class="font-heading font-bold text-xl">UMKM Seafood Denz Jarot</h1>
                    <p class="text-white/70 text-sm">Sistem Pendukung Keputusan — Metode SAW</p>
                </div>
            </div>
            <div class="border-t border-white/20 pt-4">
                <h2 class="font-heading font-bold text-lg">RIWAYAT PENILAIAN BONUS KARYAWAN</h2>
                <p class="text-white/80 text-sm mt-1">Periode: {{ $penilaian->periode_label }}</p>
            </div>
        </div>

        <div class="p-8">

            {{-- Metadata --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8 pb-6 border-b border-slate-200">
                @foreach ([['Periode', $penilaian->periode_label], ['Tanggal Cetak', now()->translatedFormat('d F Y')], ['Karyawan', $hasilSaws->count() . ' orang'], ['Penerima Bonus', $hasilSaws->where('penerima_bonus', true)->count() . ' orang']] as [$lbl, $val])
                    <div>
                        <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide mb-1">{{ $lbl }}
                        </p>
                        <p class="text-sm font-semibold text-slate-800">{{ $val }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Tabel ranking --}}
            <div class="mb-8">
                <h3 class="font-heading font-bold text-ocean text-[15px] mb-3">Hasil Perangkingan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-ocean text-white">
                                <th
                                    class="text-center px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide rounded-tl-lg">
                                    Rank</th>
                                <th class="text-left   px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide">Nama
                                    Karyawan</th>
                                <th class="text-left   px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide">Posisi
                                </th>
                                <th class="text-center px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide">Nilai
                                    Vi</th>
                                <th class="text-center px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide">Bonus
                                </th>
                                <th
                                    class="text-center px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide rounded-tr-lg">
                                    Keputusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilSaws as $h)
                                <tr class="{{ $loop->odd ? 'bg-slate-50' : 'bg-white' }}">
                                    <td
                                        class="px-4 py-2.5 border-b border-slate-100 text-center font-heading font-bold text-ocean">
                                        {{ $h->ranking }}
                                    </td>
                                    <td class="px-4 py-2.5 border-b border-slate-100 font-semibold text-slate-800">
                                        {{ $h->karyawan->nama }}</td>
                                    <td class="px-4 py-2.5 border-b border-slate-100 text-slate-600">
                                        {{ $h->karyawan->posisi }}</td>
                                    <td
                                        class="px-4 py-2.5 border-b border-slate-100 text-center font-mono font-bold
                                       {{ $h->penerima_bonus ? 'text-teal-700' : 'text-slate-500' }}">
                                        {{ number_format($h->nilai_akhir, 4) }}
                                    </td>
                                    <td
                                        class="px-4 py-2.5 border-b border-slate-100 text-center font-semibold text-teal-600">
                                        {{ $h->jumlah_bonus > 0 ? 'Rp ' . number_format($h->jumlah_bonus, 0, ',', '.') : '—' }}
                                    </td>
                                    <td class="px-4 py-2.5 border-b border-slate-100 text-center">
                                        @if ($h->penerima_bonus)
                                            <span
                                                class="bg-teal-bg text-teal-700 px-2 py-0.5 rounded-full text-xs font-semibold border border-teal-200">✓
                                                Bonus</span>
                                        @elseif($h->ranking == 5)
                                            <span
                                                class="bg-amber-50 text-amber-700 px-2 py-0.5 rounded-full text-xs font-semibold border border-amber-200">Pertimbangan</span>
                                        @else
                                            <span
                                                class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full text-xs font-semibold">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Total --}}
                            <tr class="bg-ocean/5">
                                <td colspan="4" class="px-4 py-2.5 text-right font-bold text-ocean text-sm">Total Bonus
                                    Dialokasikan:</td>
                                <td class="px-4 py-2.5 text-center font-bold text-teal-700">
                                    Rp {{ number_format($hasilSaws->sum('jumlah_bonus'), 0, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tanda tangan --}}
            <div class="grid grid-cols-2 gap-8 pt-6 border-t border-slate-200">
                <div class="text-center">
                    <p class="text-xs text-slate-500 mb-14">Mengetahui,</p>
                    <div class="border-t border-slate-400 pt-2">
                        <p class="text-sm font-semibold text-slate-700">Pemilik Usaha</p>
                        <p class="text-xs text-slate-500">Denz Jarot Seafood</p>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-xs text-slate-500 mb-14">Dicetak oleh,</p>
                    <div class="border-t border-slate-400 pt-2">
                        <p class="text-sm font-semibold text-slate-700">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs text-slate-500">{{ now()->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('styles')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            header,
            aside,
            footer {
                display: none !important;
            }

            .lg\:ml-64 {
                margin-left: 0 !important;
            }

            main {
                padding: 0 !important;
            }
        }
    </style>
@endpush
