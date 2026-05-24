{{--
================================================================
pages/hasil/partials/pembobotan.blade.php

FUNGSI  : Partial Tahap 4 SAW — Pembobotan & Nilai Preferensi Vi.
          V(i) = Σ w(j) × r(ij) untuk semua kriteria j.
          Menampilkan: detail per sel w×r + total Vi per karyawan.
          Dipanggil dari: pages/hasil/index.blade.php

VARIABEL:
  $kriterias → Collection Kriteria (with bobot)
  $karyawans → array hasil SAWService
              ['karyawan'=>obj, 'vi'=>float, 'ranking'=>int,
               'detail'=> [kriteria_id => [
                 'bobot'=>float, 'normalisasi'=>float, 'hasil_bobot'=>float
               ]]]
================================================================
--}}

{{-- <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"> --}}

    {{-- ===== HEADER ===== --}}
    <div class="flex items-start gap-4 px-6 py-5 border-b border-slate-100 bg-slate-50/50">
        <div class="w-10 h-10 rounded-xl bg-coral/15 flex items-center justify-center shrink-0 mt-0.5">
            <span class="font-heading font-black text-coral text-base">4</span>
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-bold text-coral uppercase tracking-widest">Tahap 4</span>
                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                <span class="text-[10px] text-slate-400">Pembobotan</span>
            </div>
            <h3 class="font-heading font-bold text-ocean text-[16px]">
                Pembobotan &amp; Nilai Preferensi V<sub>i</sub>
            </h3>
            <p class="text-slate-400 text-xs mt-0.5">
                Setiap nilai normalisasi r<sub>ij</sub> dikalikan bobot w<sub>j</sub>.
                Hasilnya dijumlahkan menjadi nilai preferensi akhir V<sub>i</sub> per karyawan.
            </p>
        </div>
    </div>

    <div class="p-5">

        {{-- ===== RUMUS ===== --}}
        <div
            class="bg-gradient-to-r from-ocean/5 to-teal/5 border border-ocean/15
                    rounded-xl px-5 py-4 mb-5">
            <p class="text-[10px] font-bold text-ocean uppercase tracking-widest mb-2">Formula Nilai Preferensi</p>
            <p class="font-mono text-sm font-bold text-ocean">
                V<sub>i</sub> =
                @foreach ($kriterias as $idx => $k)
                    ({{ $k->bobot }} × r<sub>i{{ $idx + 1 }}</sub>)
                    {{ !$loop->last ? ' + ' : '' }}
                @endforeach
            </p>
            <p class="text-xs text-slate-500 mt-2">
                Dimana w<sub>j</sub> = bobot kriteria &nbsp;|&nbsp;
                r<sub>ij</sub> = nilai normalisasi &nbsp;|&nbsp;
                V<sub>i</sub> = nilai akhir karyawan ke-i
            </p>
        </div>

        {{-- ===== TABEL PEMBOBOTAN ===== --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse"
                style="min-width: {{ 200 + $kriterias->count() * 120 + 100 }}px">
                <thead>
                    <tr>
                        {{-- Karyawan --}}
                        <th
                            class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                                   px-4 py-3 bg-slate-50 border border-slate-200 min-w-[160px]">
                            Karyawan
                        </th>

                        {{-- Per Kriteria --}}
                        @foreach ($kriterias as $idx => $k)
                            <th
                                class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                                   px-3 py-3 bg-slate-50 border border-slate-200">
                                w<sub>{{ $idx + 1 }}</sub> × r<sub>i{{ $idx + 1 }}</sub><br>
                                <span class="font-normal normal-case text-[10px] tracking-normal">
                                    {{ $k->kode }} (w={{ $k->bobot }})
                                </span>
                            </th>
                        @endforeach

                        {{-- Nilai Vi --}}
                        <th
                            class="text-center text-[11px] font-bold text-white uppercase tracking-wide
                                   px-4 py-3 bg-ocean border border-ocean min-w-[90px]">
                            V<sub>i</sub><br>
                            <span class="font-normal normal-case text-[10px] tracking-normal text-white/80">
                                Nilai Akhir
                            </span>
                        </th>

                        {{-- Rank --}}
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                                   px-4 py-3 bg-slate-50 border border-slate-200 min-w-[70px]">
                            Rank
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $rankBg = [
                            1 => 'bg-yellow-50/60',
                            2 => 'bg-slate-50/40',
                            3 => 'bg-orange-50/40',
                        ];
                        $rankBadge = [
                            1 => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                            2 => 'bg-slate-200 text-slate-600',
                            3 => 'bg-orange-100 text-orange-600 border border-orange-200',
                        ];
                    @endphp

                    @foreach ($karyawans as $karId => $item)
                        <tr class="{{ $rankBg[$item['ranking']] ?? '' }} hover:brightness-95 transition-all">

                            {{-- Karyawan --}}
                            <td class="px-4 py-3.5 border border-slate-200">
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

                            {{-- w × r per kriteria --}}
                            @foreach ($kriterias as $k)
                                @php
                                    $rij = $item['detail'][$k->id]['normalisasi'] ?? 0;
                                    $hasilBobot = $item['detail'][$k->id]['hasil_bobot'] ?? 0;
                                @endphp
                                <td class="px-3 py-3.5 border border-slate-200 text-center">
                                    <div class="text-[10px] text-slate-400 font-mono mb-0.5">
                                        {{ $k->bobot }} × {{ number_format($rij, 4) }}
                                    </div>
                                    <div class="font-mono font-bold text-slate-700 text-sm">
                                        = {{ number_format($hasilBobot, 4) }}
                                    </div>
                                </td>
                            @endforeach

                            {{-- Nilai Vi --}}
                            <td
                                class="px-4 py-3.5 border border-ocean/30 text-center
                                   {{ $item['ranking'] <= 2 ? 'bg-ocean text-white' : 'bg-ocean/10' }}">
                                <div
                                    class="font-heading font-black text-xl
                                        {{ $item['ranking'] <= 2 ? 'text-white' : 'text-ocean' }}">
                                    {{ number_format($item['vi'], 4) }}
                                </div>
                                @if ($item['ranking'] == 1)
                                    <div class="text-[10px] text-white/80 font-bold mt-0.5">↑ Tertinggi</div>
                                @endif
                            </td>

                            {{-- Rank --}}
                            <td class="px-4 py-3.5 border border-slate-200 text-center">
                                <span
                                    class="{{ $rankBadge[$item['ranking']] ?? 'bg-slate-100 text-slate-400' }}
                                         inline-flex items-center justify-center w-8 h-8 rounded-xl
                                         font-heading font-bold text-sm">
                                    {{ $item['ranking'] }}
                                </span>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

    <div class="px-6 py-3 border-t border-slate-100 bg-slate-50/50 flex items-center gap-3">
        <i class="fas fa-info-circle text-slate-400 text-sm shrink-0"></i>
        <p class="text-xs text-slate-500">
            Nilai V<sub>i</sub> tertinggi = karyawan terbaik.
            Karyawan diurutkan berdasarkan nilai V<sub>i</sub> dari terbesar ke terkecil.
        </p>
    </div>

{{-- </div> --}}
