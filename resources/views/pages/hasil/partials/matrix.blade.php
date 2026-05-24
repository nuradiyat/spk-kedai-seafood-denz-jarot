{{-- ================================================================
FILE : pages/hasil/partials/matrix.blade.php
FUNGSI : Tahap 1 SAW — Matriks Keputusan (X)
================================================================ --}}

@php
    $kriterias = $hasil['kriterias'];
    $karyawans = $hasil['karyawans'];
    $matrix = $hasil['matrix'];
    $max = $hasil['maxPerKriteria'];
@endphp

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

    {{-- HEADER --}}
    <div class="flex items-start gap-4 px-6 py-5 border-b border-slate-100 bg-slate-50/50">

        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0 mt-0.5">
            <span class="font-heading font-black text-blue-600 text-base">
                1
            </span>
        </div>

        <div class="flex-1">

            <div class="flex items-center gap-2 mb-1">

                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">
                    Tahap 1
                </span>

                <span class="w-1 h-1 rounded-full bg-slate-300"></span>

                <span class="text-[10px] text-slate-400">
                    Matriks Keputusan
                </span>

            </div>

            <h3 class="font-heading font-bold text-ocean text-[16px]">
                Matriks Keputusan (X)
            </h3>

            <p class="text-slate-400 text-xs mt-0.5">
                Nilai asli <em>x<sub>ij</sub></em> setiap karyawan
                pada masing-masing kriteria.
            </p>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <div class="p-5">

            <table class="w-full text-sm border-collapse whitespace-nowrap"
                style="min-width: {{ max(720, 240 + $kriterias->count() * 140) }}px">

                {{-- HEADER --}}
                <thead>

                    <tr>

                        <th
                            class="sticky left-0 z-20 bg-slate-50 border border-slate-200
                                   px-4 py-3 text-left text-[11px] font-semibold
                                   text-slate-400 uppercase min-w-[220px]">

                            Karyawan

                        </th>

                        @foreach ($kriterias as $kriteria)
                            <th
                                class="bg-slate-50 border border-slate-200
                                       px-4 py-3 text-center min-w-[130px]">

                                <span class="block font-heading font-bold text-ocean">
                                    {{ $kriteria->kode }}
                                </span>

                                <span class="block text-[10px] text-slate-400 normal-case mt-1">
                                    {{ \Illuminate\Support\Str::limit($kriteria->nama, 14) }}
                                </span>

                                <span
                                    class="inline-flex mt-1 px-2 py-0.5 rounded text-[9px] font-bold
                                    {{ $kriteria->tipe === 'benefit' ? 'bg-teal-bg text-teal-700' : 'bg-red-50 text-red-600' }}">

                                    {{ strtoupper($kriteria->tipe) }}

                                </span>

                            </th>
                        @endforeach

                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody>

                    @forelse ($karyawans as $karyawan)

                        <tr class="{{ $loop->odd ? 'bg-white' : 'bg-slate-50/40' }}">

                            {{-- KARYAWAN --}}
                            <td class="sticky left-0 z-10 bg-inherit border border-slate-200 px-4 py-3">

                                <div class="flex items-center gap-3">

                                    <span
                                        class="w-8 h-8 rounded-lg flex items-center justify-center
                                                 text-white text-xs font-bold font-heading
                                                 bg-gradient-to-br
                                                 {{ $karyawan->warna ?? 'from-slate-400 to-slate-600' }}">

                                        {{ strtoupper(substr($karyawan->nama_karyawan, 0, 2)) }}

                                    </span>

                                    <span class="font-semibold text-slate-800">

                                        {{ $karyawan->nama_karyawan }}

                                    </span>

                                </div>

                            </td>

                            {{-- NILAI --}}
                            @foreach ($kriterias as $kriteria)
                                @php
                                    $nilai = $matrix[$karyawan->id][$kriteria->id];
                                    $isMax = $nilai == $max[$kriteria->id] && $max[$kriteria->id] > 0;
                                @endphp

                                <td
                                    class="border border-slate-200 px-4 py-3 text-center
                                           {{ $isMax ? 'bg-teal-50' : '' }}">

                                    <span class="font-heading font-bold text-slate-700">

                                        {{ number_format($nilai, 2) }}

                                    </span>

                                    @if ($isMax)
                                        <span class="block text-[9px] font-bold text-teal-600 mt-1">

                                            ↑ MAX

                                        </span>
                                    @endif

                                </td>
                            @endforeach

                        </tr>

                    @empty

                        <tr>

                            <td colspan="{{ $kriterias->count() + 1 }}"
                                class="border border-slate-200 py-10 text-center text-slate-400">

                                Tidak ada data matriks keputusan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

                {{-- FOOTER --}}
                <tfoot>

                    <tr class="bg-ocean/5">

                        <td
                            class="sticky left-0 z-20 bg-ocean/5 border border-slate-200
                                   px-4 py-3 font-bold text-ocean text-xs">

                            Max(X<sub>j</sub>)

                        </td>

                        @foreach ($kriterias as $kriteria)
                            <td
                                class="border border-slate-200 px-4 py-3 text-center
                                       font-heading font-bold text-teal-700 bg-teal-bg/50">

                                {{ number_format($max[$kriteria->id], 2) }}

                            </td>
                        @endforeach

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>
