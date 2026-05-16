{{--
================================================================
pages/hasil/export.blade.php
Halaman preview export laporan hasil SAW (PDF/Excel).
Controller : HasilSawController@export
Route      : GET /hasil/{penilaian}/export → hasil.export
================================================================
--}}
@extends('layouts.app')

@section('title', 'Export Laporan — ' . $penilaian->periode_label)
@section('page-title', 'Export Laporan')
@section('page-subtitle', 'Preview laporan hasil SAW — ' . $penilaian->periode_label)

@section('content')

    {{-- ===== HEADER ===== --}}
    <div class="flex items-center justify-between mb-5 no-print">
        <div class="flex items-center gap-3">
            <a href="{{ route('hasil.detail', $penilaian->id) }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-heading font-bold text-ocean text-xl">Export Laporan</h2>
                <p class="text-slate-400 text-sm mt-0.5">{{ $penilaian->periode_label }}</p>
            </div>
        </div>
        {{-- Tombol Export --}}
        <div class="flex gap-2">
            <a href="?format=pdf"
                class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white
                  text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <i class="fas fa-file-pdf text-xs"></i> Download PDF
            </a>
            <a href="?format=excel"
                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white
                  text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <i class="fas fa-file-excel text-xs"></i> Download Excel
            </a>
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 bg-slate-700 hover:bg-slate-800 text-white
                       text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <i class="fas fa-print text-xs"></i> Print
            </button>
        </div>
    </div>

    {{-- ===== DOKUMEN LAPORAN ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        {{-- Kop Laporan --}}
        <div class="bg-gradient-to-r from-ocean to-ocean-lt px-8 py-6 text-white">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center text-2xl shrink-0">🐟</div>
                <div>
                    <h1 class="font-heading font-bold text-xl leading-tight">UMKM Seafood Denz Jarot</h1>
                    <p class="text-white/70 text-sm">Sistem Pendukung Keputusan — Metode SAW</p>
                </div>
            </div>
            <div class="border-t border-white/20 pt-4">
                <h2 class="font-heading font-bold text-lg">
                    LAPORAN HASIL PENILAIAN BONUS KARYAWAN
                </h2>
                <p class="text-white/80 text-sm mt-1">Periode: {{ $penilaian->periode_label }}</p>
            </div>
        </div>

        <div class="p-8">

            {{-- Info Laporan --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8 pb-6 border-b border-slate-200">
                @foreach ([['Periode', $penilaian->periode_label], ['Tanggal Cetak', now()->translatedFormat('d F Y')], ['Total Karyawan', $hasilSaws->count() . ' orang'], ['Penerima Bonus', $hasilSaws->where('penerima_bonus', true)->count() . ' orang']] as [$lbl, $val])
                    <div>
                        <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide mb-1">{{ $lbl }}
                        </p>
                        <p class="text-sm font-semibold text-slate-800">{{ $val }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Kriteria & Bobot --}}
            <div class="mb-8">
                <h3 class="font-heading font-bold text-ocean text-[15px] mb-3">Kriteria & Bobot Penilaian</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-ocean text-white">
                                <th
                                    class="text-left px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide rounded-tl-lg">
                                    Kode</th>
                                <th class="text-left px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide">Nama
                                    Kriteria</th>
                                <th class="text-center px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide">Tipe
                                </th>
                                <th
                                    class="text-center px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide rounded-tr-lg">
                                    Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriterias as $idx => $k)
                                <tr class="{{ $idx % 2 === 0 ? 'bg-slate-50' : 'bg-white' }}">
                                    <td class="px-4 py-2.5 border-b border-slate-100 font-heading font-bold text-ocean">
                                        {{ $k->kode }}</td>
                                    <td class="px-4 py-2.5 border-b border-slate-100 text-slate-700">{{ $k->nama }}
                                    </td>
                                    <td class="px-4 py-2.5 border-b border-slate-100 text-center">
                                        <span
                                            class="{{ $k->tipe === 'benefit' ? 'bg-teal-bg text-teal-700' : 'bg-red-50 text-red-600' }}
                                             px-2 py-0.5 rounded-full text-xs font-semibold">
                                            {{ ucfirst($k->tipe) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2.5 border-b border-slate-100 text-center font-bold text-ocean">
                                        {{ $k->bobot * 100 }}%</td>
                                </tr>
                            @endforeach
                            <tr class="bg-ocean/5">
                                <td colspan="3" class="px-4 py-2.5 font-bold text-ocean text-right text-sm">Total Bobot:
                                </td>
                                <td class="px-4 py-2.5 font-bold text-teal text-center">
                                    {{ $kriterias->sum(fn($k) => $k->bobot * 100) }}% ✓</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Hasil Ranking --}}
            <div class="mb-8">
                <h3 class="font-heading font-bold text-ocean text-[15px] mb-3">Hasil Perangkingan Karyawan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-ocean text-white">
                                <th
                                    class="text-center px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide rounded-tl-lg">
                                    Rank</th>
                                <th class="text-left   px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide">Nama
                                    Karyawan</th>
                                <th
                                    class="text-left   px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide hidden sm:table-cell">
                                    Posisi</th>
                                <th class="text-center px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide">Nilai
                                    Vi</th>
                                <th
                                    class="text-center px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide hidden md:table-cell">
                                    Bonus</th>
                                <th
                                    class="text-center px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wide rounded-tr-lg">
                                    Keputusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rankBg = [1 => 'bg-yellow-50', 2 => 'bg-slate-50', 3 => 'bg-orange-50/50'];
                                $rankBadge = [
                                    1 => 'bg-yellow-100 text-yellow-700',
                                    2 => 'bg-slate-200 text-slate-600',
                                    3 => 'bg-orange-100 text-orange-600',
                                ];
                            @endphp
                            @foreach ($hasilSaws as $h)
                                <tr
                                    class="{{ $rankBg[$h->ranking] ?? ($h->penerima_bonus ? 'bg-teal-bg/20' : 'bg-white') }}">
                                    <td class="px-4 py-3 border-b border-slate-100 text-center">
                                        <span
                                            class="{{ $rankBadge[$h->ranking] ?? 'bg-slate-100 text-slate-400' }}
                                             inline-flex items-center justify-center w-7 h-7 rounded-lg font-heading font-bold text-sm">
                                            {{ $h->ranking }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 border-b border-slate-100 font-semibold text-slate-800">
                                        {{ $h->karyawan->nama }}</td>
                                    <td class="px-4 py-3 border-b border-slate-100 text-slate-600 hidden sm:table-cell">
                                        {{ $h->karyawan->posisi }}</td>
                                    <td
                                        class="px-4 py-3 border-b border-slate-100 text-center font-mono font-bold
                                       {{ $h->ranking <= 4 ? 'text-teal-700' : 'text-slate-500' }}">
                                        {{ number_format($h->nilai_akhir, 4) }}
                                    </td>
                                    <td
                                        class="px-4 py-3 border-b border-slate-100 text-center font-semibold text-teal-600 hidden md:table-cell">
                                        {{ $h->jumlah_bonus > 0 ? 'Rp ' . number_format($h->jumlah_bonus, 0, ',', '.') : '—' }}
                                    </td>
                                    <td class="px-4 py-3 border-b border-slate-100 text-center">
                                        @if ($h->penerima_bonus)
                                            <span
                                                class="bg-teal-bg text-teal-700 px-2.5 py-0.5 rounded-full text-xs font-semibold border border-teal-200">✓
                                                Penerima Bonus</span>
                                        @elseif($h->ranking == 5)
                                            <span
                                                class="bg-amber-50 text-amber-700 px-2.5 py-0.5 rounded-full text-xs font-semibold border border-amber-200">Pertimbangan</span>
                                        @else
                                            <span
                                                class="bg-slate-100 text-slate-500 px-2.5 py-0.5 rounded-full text-xs font-semibold">Belum
                                                Memenuhi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tanda Tangan --}}
            <div class="grid grid-cols-2 gap-8 pt-6 border-t border-slate-200">
                <div class="text-center">
                    <p class="text-xs text-slate-500 mb-12">Mengetahui,</p>
                    <div class="border-t border-slate-400 pt-2">
                        <p class="text-sm font-semibold text-slate-700">Pemilik Usaha</p>
                        <p class="text-xs text-slate-500">Denz Jarot Seafood</p>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-xs text-slate-500 mb-12">Dibuat oleh,</p>
                    <div class="border-t border-slate-400 pt-2">
                        <p class="text-sm font-semibold text-slate-700">{{ $penilaian->creator->name ?? 'Administrator' }}
                        </p>
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
