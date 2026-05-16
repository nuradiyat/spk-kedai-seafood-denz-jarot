{{--
================================================================
pages/riwayat/detail.blade.php
Detail satu riwayat penilaian: ranking + nilai tiap karyawan.
Controller : RiwayatPenilaianController@detail
Route      : GET /riwayat/{penilaian} → riwayat.detail
================================================================
--}}
@extends('layouts.app')

@section('title', 'Detail Riwayat — ' . $penilaian->periode_label)
@section('page-title', 'Detail Riwayat')
@section('page-subtitle', 'Riwayat penilaian — ' . $penilaian->periode_label)

@section('content')

    {{-- ===== HEADER ===== --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('riwayat.index') }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-heading font-bold text-ocean text-xl">{{ $penilaian->judul }}</h2>
                <p class="text-slate-400 text-sm mt-0.5">{{ $penilaian->periode_label }}</p>
            </div>
        </div>
        <div class="flex gap-2 no-print">
            <a href="{{ route('riwayat.export', $penilaian->id) }}"
                class="inline-flex items-center gap-2 border border-slate-200 bg-white text-slate-600
                  text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                <i class="fas fa-download text-xs"></i> Export
            </a>
            <a href="{{ route('hasil.detail', $penilaian->id) }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt text-white
                  text-sm font-medium px-4 py-2.5 rounded-xl hover:-translate-y-0.5 hover:shadow-md transition-all">
                <i class="fas fa-calculator text-xs"></i> Detail SAW
            </a>
        </div>
    </div>

    {{-- ===== INFO CARDS ===== --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">
        @foreach ([['Periode', $penilaian->periode_label, 'fa-calendar-alt', 'ocean'], ['Karyawan', $hasilSaws->count() . ' orang', 'fa-users', 'sea'], ['Penerima Bonus', $hasilSaws->where('penerima_bonus', true)->count() . ' orang', 'fa-trophy', 'sea'], ['Total Bonus', 'Rp ' . number_format($hasilSaws->where('penerima_bonus', true)->sum('jumlah_bonus'), 0, ',', '.'), 'fa-money-bill-wave', 'coral']] as [$lbl, $val, $icon, $color])
            <div class="bg-white rounded-2xl border border-slate-200 p-4">
                <div class="flex items-center gap-2 mb-2">
                    <div
                        class="w-7 h-7 rounded-lg flex items-center justify-center text-xs
                        {{ $color === 'sea' ? 'bg-teal/10 text-teal-700' : ($color === 'coral' ? 'bg-coral/10 text-coral' : 'bg-ocean/10 text-ocean') }}">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">{{ $lbl }}</p>
                </div>
                <p class="font-heading font-bold text-ocean text-sm">{{ $val }}</p>
            </div>
        @endforeach
    </div>

    {{-- ===== PEMENANG PERIODE ===== --}}
    @php $rank1 = $hasilSaws->firstWhere('ranking', 1); @endphp
    @if ($rank1)
        <div
            class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200
            rounded-2xl p-5 mb-5 flex items-center gap-4">
            <div class="text-4xl shrink-0">👑</div>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] text-yellow-700 font-bold uppercase tracking-wide mb-1">Peringkat 1 —
                    {{ $penilaian->periode_label }}</p>
                <p class="font-heading font-bold text-ocean text-xl">{{ $rank1->karyawan->nama }}</p>
                <p class="text-slate-500 text-sm">{{ $rank1->karyawan->posisi }}</p>
            </div>
            <div class="text-right shrink-0">
                <p class="font-heading font-bold text-teal-700 text-2xl">{{ number_format($rank1->nilai_akhir, 4) }}</p>
                <p class="text-xs text-slate-400">Nilai Vi</p>
                @if ($rank1->jumlah_bonus > 0)
                    <p class="text-sm font-bold text-teal-600 mt-1">Rp
                        {{ number_format($rank1->jumlah_bonus, 0, ',', '.') }}</p>
                @endif
            </div>
        </div>
    @endif

    {{-- ===== TABEL RIWAYAT RANKING ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-5">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-heading font-bold text-ocean text-[15px]">Hasil Ranking Lengkap</h3>
            <span class="text-xs text-slate-400">{{ $penilaian->periode_label }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-4 py-3.5">
                            Rank</th>
                        <th
                            class="text-left   text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Karyawan</th>
                        @foreach ($kriterias as $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                                {{ $k->kode }}</th>
                        @endforeach
                        <th class="text-center text-[11px] font-bold text-teal-700 uppercase tracking-wide px-3 py-3.5">
                            V<sub>i</sub></th>
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden sm:table-cell">
                            Bonus</th>
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                            Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rankBg = [1 => 'bg-yellow-50/50', 2 => 'bg-slate-50/30', 3 => 'bg-orange-50/30'];
                        $rankBadge = [
                            1 => 'bg-yellow-100 text-yellow-700',
                            2 => 'bg-slate-200 text-slate-600',
                            3 => 'bg-orange-100 text-orange-600',
                        ];
                    @endphp
                    @foreach ($hasilSaws as $h)
                        <tr class="border-b border-slate-50 last:border-0 tbl-row {{ $rankBg[$h->ranking] ?? '' }}">
                            <td class="px-4 py-3.5 text-center">
                                <span
                                    class="{{ $rankBadge[$h->ranking] ?? 'bg-slate-100 text-slate-400' }}
                                     inline-flex items-center justify-center w-7 h-7 rounded-lg font-heading font-bold text-sm">
                                    {{ $h->ranking }}
                                </span>
                            </td>
                            <td class="px-3 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0
                                         text-white text-xs font-bold font-heading
                                         bg-gradient-to-br {{ $h->karyawan->warna ?? 'from-slate-400 to-slate-600' }}">
                                        {{ strtoupper(substr($h->karyawan->nama, 0, 2)) }}
                                    </span>
                                    <div>
                                        <p class="font-semibold text-slate-800 text-sm">{{ $h->karyawan->nama }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $h->karyawan->posisi }}</p>
                                    </div>
                                </div>
                            </td>
                            @foreach ($kriterias as $k)
                                <td class="px-3 py-3.5 text-center text-slate-600 hidden md:table-cell font-mono">
                                    {{ $h->detail_normalisasi[$k->id]['nilai_asli'] ?? '—' }}
                                </td>
                            @endforeach
                            <td
                                class="px-3 py-3.5 text-center font-mono font-bold
                               {{ $h->ranking <= 4 ? 'text-teal-700' : 'text-slate-400' }}">
                                {{ number_format($h->nilai_akhir, 4) }}
                            </td>
                            <td class="px-3 py-3.5 text-center font-semibold text-teal-600 text-sm hidden sm:table-cell">
                                {{ $h->jumlah_bonus > 0 ? 'Rp ' . number_format($h->jumlah_bonus, 0, ',', '.') : '—' }}
                            </td>
                            <td class="px-3 py-3.5 text-center">
                                @if ($h->penerima_bonus)
                                    @include('components.badges.status', ['status' => 'bonus'])
                                @elseif($h->ranking == 5)
                                    @include('components.badges.status', ['status' => 'pertimbangan'])
                                @else
                                    @include('components.badges.status', ['status' => 'tidak'])
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== NAVIGASI KE RIWAYAT SEBELUMNYA / BERIKUTNYA ===== --}}
    <div class="flex justify-between gap-3 no-print">
        @if (isset($prevPenilaian))
            <a href="{{ route('riwayat.detail', $prevPenilaian->id) }}"
                class="flex items-center gap-2 bg-white border border-slate-200 text-slate-600
              text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                <i class="fas fa-chevron-left text-xs"></i> {{ $prevPenilaian->periode_label }}
            </a>
        @else
            <div></div>
        @endif
        @if (isset($nextPenilaian))
            <a href="{{ route('riwayat.detail', $nextPenilaian->id) }}"
                class="flex items-center gap-2 bg-white border border-slate-200 text-slate-600
              text-sm font-medium px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                {{ $nextPenilaian->periode_label }} <i class="fas fa-chevron-right text-xs"></i>
            </a>
        @endif
    </div>

@endsection
