{{--
================================================================
pages/hasil/partials/max.blade.php

FUNGSI  : Partial Tahap 2 SAW — Nilai Maksimum & Minimum.
          Menampilkan nilai MAX dan MIN tiap kriteria.
          Nilai MAX digunakan sebagai pembagi normalisasi benefit.
          Nilai MIN digunakan sebagai pembagi normalisasi cost.
          Dipanggil dari: pages/hasil/index.blade.php

VARIABEL:
  $kriterias      → Collection Kriteria
  $maxPerKriteria → array [kriteria_id => max_value]
  $minPerKriteria → array [kriteria_id => min_value]
================================================================
--}}

{{-- <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"> --}}

    {{-- ===== HEADER ===== --}}
    <div class="flex items-start gap-4 px-6 py-5 border-b border-slate-100 bg-slate-50/50">
        <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center shrink-0 mt-0.5">
            <span class="font-heading font-black text-purple-600 text-base">2</span>
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-bold text-purple-600 uppercase tracking-widest">Tahap 2</span>
                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                <span class="text-[10px] text-slate-400">Nilai Maksimum & Minimum</span>
            </div>
            <h3 class="font-heading font-bold text-ocean text-[16px]">Nilai Max &amp; Min per Kriteria</h3>
            <p class="text-slate-400 text-xs mt-0.5">
                Nilai terbesar dan terkecil dari setiap kolom kriteria.
                Digunakan sebagai pembagi pada proses normalisasi tahap berikutnya.
            </p>
        </div>
    </div>

    <div class="p-5">

        {{-- ===== RUMUS BOX ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-5">

            {{-- Benefit --}}
            <div class="flex items-start gap-3 bg-teal-bg border border-teal-200 rounded-xl p-4">
                <div class="w-8 h-8 rounded-lg bg-teal/20 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas fa-arrow-up text-teal-600 text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-teal-700 uppercase tracking-wide mb-1">Rumus Benefit</p>
                    <p class="font-mono text-sm text-teal-800 font-bold">
                        r<sub>ij</sub> = x<sub>ij</sub> ÷ <strong>Max(x<sub>j</sub>)</strong>
                    </p>
                    <p class="text-xs text-teal-600 mt-1">Nilai lebih besar = lebih baik</p>
                </div>
            </div>

            {{-- Cost --}}
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas fa-arrow-down text-red-500 text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-red-700 uppercase tracking-wide mb-1">Rumus Cost</p>
                    <p class="font-mono text-sm text-red-800 font-bold">
                        r<sub>ij</sub> = <strong>Min(x<sub>j</sub>)</strong> ÷ x<sub>ij</sub>
                    </p>
                    <p class="text-xs text-red-600 mt-1">Nilai lebih kecil = lebih baik</p>
                </div>
            </div>

        </div>

        {{-- ===== TABEL MAX & MIN ===== --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse" style="min-width: {{ 180 + $kriterias->count() * 110 }}px">

                <thead>
                    <tr>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                                   px-4 py-3 bg-slate-50 border border-slate-200 min-w-[160px]">
                            Keterangan
                        </th>
                        @foreach ($kriterias as $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                                   px-4 py-3 bg-slate-50 border border-slate-200">
                                <span class="block font-heading font-bold text-ocean">{{ $k->kode }}</span>
                                <span class="block text-[10px] font-normal normal-case tracking-normal mt-0.5">
                                    {{ Str::limit($k->nama, 12) }}
                                </span>
                                <span
                                    class="inline-block mt-1 text-[9px] font-bold px-1.5 py-0.5 rounded
                                         {{ $k->tipe === 'benefit' ? 'bg-teal-bg text-teal-700' : 'bg-red-50 text-red-600' }}">
                                    {{ strtoupper($k->tipe) }}
                                </span>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>

                    {{-- Baris Nilai MAX --}}
                    <tr class="bg-teal-bg/30">
                        <td class="px-4 py-3 border border-slate-200">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-teal/20 flex items-center justify-center shrink-0">
                                    <i class="fas fa-arrow-up text-teal-600 text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">Nilai Terbesar (Max)</p>
                                    <p class="text-[10px] text-slate-400 font-mono">Max(X<sub>j</sub>)</p>
                                </div>
                            </div>
                        </td>
                        @foreach ($kriterias as $k)
                            <td class="px-4 py-3 border border-slate-200 text-center">
                                <span class="font-heading font-bold text-teal-700 text-xl">
                                    {{ $maxPerKriteria[$k->id] ?? '—' }}
                                </span>
                                @if ($k->tipe === 'benefit')
                                    <span class="block text-[9px] text-teal-500 font-bold mt-0.5">← dipakai</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    {{-- Baris Nilai MIN --}}
                    <tr class="bg-red-50/30">
                        <td class="px-4 py-3 border border-slate-200">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-red-100 flex items-center justify-center shrink-0">
                                    <i class="fas fa-arrow-down text-red-500 text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">Nilai Terkecil (Min)</p>
                                    <p class="text-[10px] text-slate-400 font-mono">Min(X<sub>j</sub>)</p>
                                </div>
                            </div>
                        </td>
                        @foreach ($kriterias as $k)
                            <td class="px-4 py-3 border border-slate-200 text-center">
                                <span class="font-heading font-bold text-red-500 text-xl">
                                    {{ $minPerKriteria[$k->id] ?? '—' }}
                                </span>
                                @if ($k->tipe === 'cost')
                                    <span class="block text-[9px] text-red-400 font-bold mt-0.5">← dipakai</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    {{-- Baris: pembagi yang digunakan --}}
                    <tr class="bg-ocean/5">
                        <td class="px-4 py-3 border border-slate-200">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-ocean/10 flex items-center justify-center shrink-0">
                                    <i class="fas fa-divide text-ocean text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-ocean text-sm">Pembagi Normalisasi</p>
                                    <p class="text-[10px] text-slate-400">Nilai yang digunakan untuk normalisasi</p>
                                </div>
                            </div>
                        </td>
                        @foreach ($kriterias as $k)
                            <td class="px-4 py-3 border border-slate-200 text-center">
                                <span class="font-heading font-bold text-ocean text-xl">
                                    {{ $k->tipe === 'benefit' ? $maxPerKriteria[$k->id] ?? '—' : $minPerKriteria[$k->id] ?? '—' }}
                                </span>
                                <span class="block text-[9px] text-slate-400 mt-0.5">
                                    {{ $k->tipe === 'benefit' ? 'dari MAX' : 'dari MIN' }}
                                </span>
                            </td>
                        @endforeach
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

    {{-- Info footer --}}
    <div class="px-6 py-3 border-t border-slate-100 bg-slate-50/50 flex items-center gap-3">
        <i class="fas fa-info-circle text-slate-400 text-sm shrink-0"></i>
        <p class="text-xs text-slate-500">
            Kriteria <strong>Benefit</strong>: pembagi = nilai MAX (makin besar makin baik).
            Kriteria <strong>Cost</strong>: pembagi = nilai MIN (makin kecil makin baik).
        </p>
    </div>

{{-- </div> --}}
