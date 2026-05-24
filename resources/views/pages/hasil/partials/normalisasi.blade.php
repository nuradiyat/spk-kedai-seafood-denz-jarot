{{--
================================================================
pages/hasil/partials/normalisasi.blade.php

FUNGSI  : Partial Tahap 3 SAW — Matriks Normalisasi (R).
          Benefit : r(ij) = x(ij) / Max(x(j))
          Cost    : r(ij) = Min(x(j)) / x(ij)
          Dipanggil dari: pages/hasil/index.blade.php

VARIABEL:
  $kriterias      → Collection Kriteria
  $karyawans      → array hasil SAWService
  $maxPerKriteria → array [kriteria_id => max]
  $minPerKriteria → array [kriteria_id => min]
================================================================
--}}

{{-- <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"> --}}

    {{-- HEADER --}}
    <div class="flex items-start gap-4 px-6 py-5 border-b border-slate-100 bg-slate-50/50">
        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
            <span class="font-heading font-black text-amber-600 text-base">3</span>
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">Tahap 3</span>
                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                <span class="text-[10px] text-slate-400">Normalisasi</span>
            </div>
            <h3 class="font-heading font-bold text-ocean text-[16px]">Matriks Normalisasi (R)</h3>
            <p class="text-slate-400 text-xs mt-0.5">
                Setiap nilai dibagi dengan pembagi normalisasi kriterianya.
                Nilai <span class="bg-teal-bg text-teal-700 px-1.5 py-0.5 rounded text-[10px] font-bold">1.0000</span>
                = nilai terbaik pada kolom tersebut.
            </p>
        </div>
    </div>

    <div class="p-5">

        {{-- Rumus --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-5">
            <div class="bg-teal-bg border border-teal-200 rounded-xl px-4 py-3">
                <p class="text-[10px] font-bold text-teal-700 uppercase tracking-wide mb-1.5">Benefit</p>
                <p class="font-mono text-sm font-bold text-teal-800">
                    r<sub>ij</sub> = x<sub>ij</sub> ÷ Max(x<sub>j</sub>)
                </p>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                <p class="text-[10px] font-bold text-red-600 uppercase tracking-wide mb-1.5">Cost</p>
                <p class="font-mono text-sm font-bold text-red-700">
                    r<sub>ij</sub> = Min(x<sub>j</sub>) ÷ x<sub>ij</sub>
                </p>
            </div>
        </div>

        {{-- Tabel Normalisasi --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse" style="min-width: {{ 200 + $kriterias->count() * 130 }}px">
                <thead>
                    <tr>
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                                   px-4 py-3 bg-slate-50 border border-slate-200 min-w-[160px]">
                            Karyawan
                        </th>
                        @foreach ($kriterias as $idx => $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                                   px-4 py-3 bg-slate-50 border border-slate-200">
                                r<sub>i{{ $idx + 1 }}</sub><br>
                                <span class="font-normal normal-case text-[10px] tracking-normal">
                                    {{ $k->kode }}
                                    ({{ $k->tipe === 'benefit' ? '÷' . $maxPerKriteria[$k->id] : $minPerKriteria[$k->id] . '÷' }})
                                </span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawans as $karId => $item)
                        <tr class="{{ $loop->odd ? 'bg-white' : 'bg-slate-50/40' }}">

                            {{-- Karyawan --}}
                            <td class="px-4 py-3 border border-slate-200">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0
                                             text-white text-[10px] font-bold font-heading
                                             bg-gradient-to-br {{ $item['karyawan']->warna ?? 'from-slate-400 to-slate-600' }}">
                                        {{ strtoupper(substr($item['karyawan']->nama_karyawan, 0, 2)) }}
                                    </span>
                                    <span class="font-semibold text-slate-800 text-sm">
                                        {{ $item['karyawan']->nama_karyawan }}
                                    </span>
                                </div>
                            </td>

                            {{-- Nilai normalisasi per kriteria --}}
                            @foreach ($kriterias as $k)
                                @php
                                    $xij = $item['detail'][$k->id]['nilai_asli'] ?? 0;
                                    $rij = $item['detail'][$k->id]['normalisasi'] ?? 0;
                                    $maks = $maxPerKriteria[$k->id] ?? 1;
                                    $mins = $minPerKriteria[$k->id] ?? 0;
                                    $isPerfect = $rij >= 1.0;
                                @endphp
                                <td
                                    class="px-3 py-3 border border-slate-200 text-center
                                   {{ $isPerfect ? 'cell-best' : 'text-slate-700' }}">
                                    {{-- Perhitungan --}}
                                    <div class="text-[10px] text-slate-400 font-mono mb-0.5">
                                        {{ $k->tipe === 'benefit' ? $xij . '/' . $maks : $mins . '/' . $xij }}
                                    </div>
                                    {{-- Hasil --}}
                                    <div class="font-heading font-bold text-sm">
                                        {{ number_format($rij, 4) }}
                                    </div>
                                    @if ($isPerfect)
                                        <div class="text-[9px] text-teal-600 font-bold mt-0.5">★ Terbaik</div>
                                    @endif
                                </td>
                            @endforeach

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="px-6 py-3 border-t border-slate-100 bg-slate-50/50 flex items-center gap-3">
        <i class="fas fa-info-circle text-slate-400 text-sm shrink-0"></i>
        <p class="text-xs text-slate-500">
            Semua nilai ternormalisasi berada dalam rentang <strong>0 – 1</strong>.
            Nilai <strong>1.0000</strong> menunjukkan karyawan terbaik pada kriteria tersebut.
        </p>
    </div>

{{-- </div> --}}