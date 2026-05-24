{{-- ==========================================================
FILE : pages/hasil/partials/kesimpulan.blade.php
Tahap 5 — Kesimpulan Hasil SAW
========================================================== --}}

@php
    $rankingData = collect($hasil['rankingData'] ?? []);
    $peringkatPertama = $hasil['peringkatPertama'] ?? null;
@endphp

{{-- <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"> --}}

    {{-- HEADER --}}
    <div
        class="flex items-start gap-4 px-6 py-5
                border-b border-slate-100
                bg-gradient-to-r from-teal/5 to-ocean/5">

        <div
            class="w-10 h-10 rounded-xl
                    bg-teal/20
                    flex items-center justify-center
                    shrink-0">

            <span class="font-heading font-black text-teal-700">

                5

            </span>

        </div>

        <div class="flex-1">

            <div class="flex items-center gap-2 mb-1">

                <span
                    class="text-[10px]
                             font-bold
                             text-teal-700
                             uppercase tracking-widest">

                    Tahap 5

                </span>

                <span class="w-1 h-1 rounded-full bg-slate-300"></span>

                <span class="text-[10px] text-slate-400">

                    Kesimpulan Akhir

                </span>

            </div>

            <h3 class="font-heading font-bold text-ocean text-[16px]">

                Ranking & Penerima Bonus

            </h3>

            <p class="text-slate-400 text-xs mt-1">

                Hasil akhir metode SAW berdasarkan nilai preferensi
                <strong>V<sub>i</sub></strong>.

            </p>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead>

                <tr class="bg-slate-50">

                    <th class="px-4 py-3 border-b text-center">

                        Rank

                    </th>

                    <th class="px-4 py-3 border-b text-left">

                        Karyawan

                    </th>

                    <th class="px-4 py-3 border-b text-center">

                        Nilai Vi

                    </th>

                    <th class="px-4 py-3 border-b text-center">

                        Status

                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($rankingData as $item)
                    <tr class="border-b border-slate-100
                               hover:bg-slate-50 transition">

                        {{-- Ranking --}}
                        <td class="px-4 py-4 text-center">

                            <span
                                class="inline-flex
                                         items-center
                                         justify-center
                                         w-8 h-8
                                         rounded-xl
                                         bg-slate-100
                                         font-bold
                                         text-slate-700">

                                {{ $item['ranking'] }}

                            </span>

                        </td>

                        {{-- Karyawan --}}
                        <td class="px-4 py-4">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-10 h-10
                                            rounded-xl
                                            flex items-center justify-center
                                            text-white text-xs font-bold
                                            bg-gradient-to-br
                                            {{ $item['karyawan']->warna ?? 'from-slate-400 to-slate-600' }}">

                                    {{ strtoupper(substr($item['karyawan']->nama_karyawan, 0, 2)) }}

                                </div>

                                <div>

                                    <p class="font-semibold text-slate-800">

                                        {{ $item['karyawan']->nama_karyawan }}

                                    </p>

                                    <p class="text-xs text-slate-400">

                                        {{ $item['karyawan']->jabatan ?? '-' }}

                                    </p>

                                </div>

                            </div>

                        </td>

                        {{-- VI --}}
                        <td class="px-4 py-4 text-center">

                            <span
                                class="font-heading
                                         font-bold
                                         text-ocean
                                         text-base">

                                {{ number_format($item['vi'], 4) }}

                            </span>

                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-4 text-center">

                            @if ($item['penerima_bonus'])
                                <span
                                    class="inline-flex
                                             items-center
                                             px-3 py-1.5
                                             rounded-full
                                             bg-teal-bg
                                             text-teal-700
                                             border border-teal-200
                                             text-xs font-semibold">

                                    Penerima Bonus

                                </span>
                            @else
                                <span
                                    class="inline-flex
                                             items-center
                                             px-3 py-1.5
                                             rounded-full
                                             bg-slate-100
                                             text-slate-500
                                             text-xs">

                                    Tidak Memenuhi

                                </span>
                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="py-10 text-center text-slate-400">

                            Data hasil SAW belum tersedia.

                        </td>

                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    {{-- FOOTER SUMMARY --}}
    <div
        class="px-6 py-5
                bg-gradient-to-r
                from-ocean
                to-ocean-lt
                text-white">

        <h4 class="font-heading font-bold mb-2">

            Ringkasan Hasil

        </h4>

        <p class="text-sm text-white/85 leading-relaxed">

            Berdasarkan hasil perhitungan
            <strong>Simple Additive Weighting (SAW)</strong>,
            karyawan dengan nilai preferensi tertinggi adalah

            <strong>

                {{ $peringkatPertama['karyawan']->nama_karyawan ?? '-' }}

            </strong>

            dengan nilai

            <strong>

                {{ number_format($peringkatPertama['vi'] ?? 0, 4) }}

            </strong>.

        </p>

    </div>

{{-- </div> --}}
