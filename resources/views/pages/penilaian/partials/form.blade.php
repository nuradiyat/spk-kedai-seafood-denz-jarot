{{--
================================================================
pages/penilaian/partials/form.blade.php

FUNGSI : Partial reusable — field form input nilai karyawan.
         Dipakai oleh create.blade.php dan edit.blade.php.
         HANYA berisi input data nilai mentah (X).
         Tidak ada proses SAW di sini.

$penilaian : optional, diisi saat mode edit
$karyawans : Collection karyawan aktif dari controller
$kriterias : Collection kriteria dari controller
$nilaiLama : array nilai yang sudah ada (untuk edit)
             format: $nilaiLama[karyawan_id][kriteria_id] = nilai
================================================================
--}}

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-5">

    <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 bg-slate-50/50">

        <div class="w-8 h-8 rounded-lg bg-ocean/10 flex items-center justify-center shrink-0">
            <i class="fas fa-calendar-alt text-ocean text-sm"></i>
        </div>

        <h3 class="font-heading font-bold text-ocean text-[15px]">
            Informasi Periode
        </h3>

    </div>

    <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-5">

        {{-- PERIODE (FIX FINAL AMAN CREATE + EDIT) --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
                Periode Penilaian <span class="text-red-400">*</span>
            </label>

            <input type="month" name="periode"
                value="{{ old('periode', isset($penilaian) ? \Carbon\Carbon::parse($penilaian->periode)->format('Y-m') : now()->format('Y-m')) }}"
                {{ !empty($penilaian) ? 'readonly' : '' }} required
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                transition-all
                {{ !empty($penilaian) ? 'opacity-70 cursor-not-allowed' : '' }}">

            @error('periode')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- TANGGAL --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
                Tanggal Penilaian <span class="text-red-400">*</span>
            </label>

            <input type="date" name="tanggal_penilaian"
                value="{{ old('tanggal_penilaian', $penilaian->tanggal_penilaian ?? now()->format('Y-m-d')) }}" required
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white">

            @error('tanggal_penilaian')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- KETERANGAN --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
                Keterangan
            </label>

            <input type="text" name="keterangan" value="{{ old('keterangan', $penilaian->keterangan ?? '') }}"
                placeholder="Contoh: Penilaian bonus semester 1"
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white">
        </div>

    </div>
</div>

{{-- =========================================================
BAGIAN SKALA NILAI
========================================================= --}}
<div class="flex flex-wrap gap-2 mb-5">

    <span class="text-xs font-semibold text-slate-500 self-center mr-1">
        Skala Nilai:
    </span>

    @foreach ([
        1 => ['Sangat Buruk', 'bg-red-100 text-red-700 border-red-200'],
        2 => ['Buruk', 'bg-orange-100 text-orange-700 border-orange-200'],
        3 => ['Cukup', 'bg-amber-100 text-amber-700 border-amber-200'],
        4 => ['Baik', 'bg-teal-bg text-teal-700 border-teal-200'],
        5 => ['Sangat Baik', 'bg-green-50 text-green-700 border-green-200'],
    ] as $value => [$label, $class])
        <span
            class="inline-flex items-center gap-1.5 {{ $class }} border px-3 py-1 rounded-full text-xs font-semibold">
            <span class="font-bold">{{ $value }}</span>
            <span>= {{ $label }}</span>
        </span>
    @endforeach
</div>

{{-- =========================================================
BAGIAN MATRIX NILAI
========================================================= --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">

        <div class="flex items-center gap-3">

            <div class="w-8 h-8 rounded-lg bg-ocean/10 flex items-center justify-center shrink-0">
                <i class="fas fa-table text-ocean text-sm"></i>
            </div>

            <div>
                <h3 class="font-heading font-bold text-ocean text-[15px]">
                    Input Nilai Karyawan
                </h3>

                <p class="text-slate-400 text-xs mt-0.5">
                    {{ $karyawans->count() }} karyawan × {{ $kriterias->count() }} kriteria
                </p>
            </div>

        </div>

        <span class="text-xs text-slate-400 bg-slate-100 px-3 py-1.5 rounded-lg">
            Isi semua kolom nilai
        </span>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-sm" style="min-width: {{ 200 + $kriterias->count() * 120 }}px">

            <thead class="bg-slate-50 border-b border-slate-200">

                <tr>

                    <th
                        class="text-left text-[11px] font-semibold text-slate-400 uppercase px-6 py-3.5 sticky left-0 bg-slate-50 min-w-[200px]">
                        Karyawan
                    </th>

                    @foreach ($kriterias as $kriteria)
                        <th
                            class="text-center text-[11px] font-semibold text-slate-400 uppercase px-4 py-3.5 min-w-[110px]">

                            <div class="font-heading font-bold text-ocean text-sm">
                                {{ $kriteria->kode }}
                            </div>

                            <div class="text-[10px] text-slate-400 mt-1">
                                {{ $kriteria->nama_kriteria }}
                            </div>

                        </th>
                    @endforeach

                </tr>

            </thead>

            <tbody>

                @foreach ($karyawans as $karyawan)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50">

                        <td class="px-6 py-3.5 sticky left-0 bg-white">

                            <div class="flex items-center gap-3">

                                <span
                                    class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-xs font-bold
                                bg-gradient-to-br {{ $karyawan->warna ?? 'from-slate-400 to-slate-600' }}">

                                    {{ strtoupper(substr($karyawan->nama_karyawan, 0, 2)) }}

                                </span>

                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">
                                        {{ $karyawan->nama_karyawan }}
                                    </p>

                                    <p class="text-[11px] text-slate-400">
                                        {{ $karyawan->jabatan ?? '—' }}
                                    </p>
                                </div>

                            </div>

                        </td>

                        @foreach ($kriterias as $kriteria)
                            @php
                                $nilaiExisting = $nilaiLama[$karyawan->id][$kriteria->id] ?? null;
                            @endphp

                            <td class="px-4 py-3.5 text-center">

                                <input type="number" name="nilai[{{ $karyawan->id }}][{{ $kriteria->id }}]"
                                    value="{{ old('nilai.' . $karyawan->id . '.' . $kriteria->id, $nilaiExisting) }}"
                                    min="1" max="5" required
                                    class="w-16 h-10 text-center rounded-xl border-2 border-slate-200 bg-sand
                                    text-slate-900 text-sm font-bold focus:outline-none focus:border-teal">

                            </td>
                        @endforeach

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>
