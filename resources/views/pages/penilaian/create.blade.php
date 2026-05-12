{{--
================================================================
pages/penilaian/create.blade.php
Form input nilai karyawan per kriteria (matriks input).
Controller : PenilaianController@create, @store / @edit, @update
Route      : GET  /penilaian/create → penilaian.create
             POST /penilaian        → penilaian.store
================================================================
--}}
@extends('layouts.app')

@section('title', isset($penilaian) ? 'Edit Penilaian' : 'Input Penilaian Baru')
@section('page-title', isset($penilaian) ? 'Edit Nilai Penilaian' : 'Input Penilaian Baru')
@section('page-subtitle', 'Isi nilai setiap karyawan berdasarkan kriteria (skala 1–5)')

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('penilaian.index') }}"
                class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
                  flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-heading font-bold text-ocean text-xl">
                    {{ isset($penilaian) ? 'Edit Nilai — ' . $penilaian->periode_label : 'Input Penilaian Baru' }}
                </h2>
                <p class="text-slate-400 text-sm mt-0.5">Skala nilai: 1 (Sangat Buruk) — 5 (Sangat Baik)</p>
            </div>
        </div>
        {{-- Tombol simpan --}}
        <button form="formPenilaian" type="submit"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-teal text-white
                   text-sm font-semibold px-5 py-2.5 rounded-xl hover:-translate-y-0.5
                   hover:shadow-md transition-all duration-200">
            <i class="fas fa-save text-xs"></i> Simpan Penilaian
        </button>
    </div>

    {{-- Info keterangan skala --}}
    <div class="flex flex-wrap gap-2 mb-5">
        @foreach ([1 => 'Sangat Buruk', 2 => 'Buruk', 3 => 'Cukup', 4 => 'Baik', 5 => 'Sangat Baik'] as $val => $lbl)
            <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs">
                <span
                    class="w-5 h-5 rounded-md {{ $val >= 4 ? 'bg-teal' : ($val == 3 ? 'bg-amber-400' : 'bg-red-400') }}
                     text-white flex items-center justify-center font-bold text-[10px]">{{ $val }}</span>
                <span class="text-slate-600">{{ $lbl }}</span>
            </div>
        @endforeach
    </div>

    <form id="formPenilaian" method="POST"
        action="{{ isset($penilaian) ? route('penilaian.update', $penilaian->id) : route('penilaian.store') }}">
        @csrf
        @if (isset($penilaian))
            @method('PUT')
        @endif

        {{-- ============================================================
         PERIODE & JUDUL
    ============================================================ --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
                        Periode <span class="text-red-400">*</span>
                    </label>
                    <input type="month" name="periode"
                        value="{{ old('periode', isset($penilaian) ? $penilaian->periode : $periodeDefault ?? now()->format('Y-m')) }}"
                        {{ isset($penilaian) ? 'readonly' : '' }}
                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                              text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                              transition-all @error('periode') border-red-400 @enderror"
                        required>
                    @error('periode')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Judul
                        Penilaian</label>
                    <input type="text" name="judul" value="{{ old('judul', $penilaian->judul ?? '') }}"
                        placeholder="cth: Penilaian Bonus Mei 2025"
                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                              text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white transition-all">
                </div>
            </div>
        </div>

        {{-- ============================================================
         MATRIKS INPUT NILAI
    ============================================================ --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h3 class="font-heading font-bold text-ocean text-[15px]">Matriks Nilai Karyawan</h3>
                <div class="text-xs text-slate-400">
                    {{ $karyawans->count() }} karyawan × {{ $kriterias->count() }} kriteria
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm" style="min-width:650px">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th
                                class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide
                                   px-5 py-3.5 sticky left-0 bg-slate-50 min-w-[160px]">
                                Karyawan
                            </th>
                            @foreach ($kriterias as $k)
                                <th
                                    class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 min-w-[110px]">
                                    <span class="font-heading font-bold text-ocean">{{ $k->kode }}</span><br>
                                    <span
                                        class="font-normal normal-case tracking-normal text-[10px]">{{ $k->nama }}</span><br>
                                    <span class="text-teal text-[10px] font-semibold">W={{ $k->bobot * 100 }}%</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karyawans as $kar)
                            <tr class="border-b border-slate-50 last:border-0 tbl-row">
                                <td class="px-5 py-3 sticky left-0 bg-white">
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="w-8 h-8 rounded-lg flex items-center justify-center
                                             text-white text-xs font-bold font-heading shrink-0
                                             bg-gradient-to-br {{ $kar->warna ?? 'from-slate-400 to-slate-600' }}">
                                            {{ strtoupper(substr($kar->nama, 0, 2)) }}
                                        </span>
                                        <span class="font-semibold text-slate-800 text-sm">{{ $kar->nama }}</span>
                                    </div>
                                </td>
                                @foreach ($kriterias as $k)
                                    @php
                                        $existingVal = $nilaiMatrix[$kar->id][$k->id] ?? '';
                                    @endphp
                                    <td class="px-3 py-3 text-center">
                                        <input type="number" min="1" max="5" step="1"
                                            name="nilai[{{ $kar->id }}][{{ $k->id }}]"
                                            value="{{ old("nilai.{$kar->id}.{$k->id}", $existingVal) }}" placeholder="1-5"
                                            class="w-14 h-10 text-center rounded-xl border-2 border-slate-200 bg-sand
                                          text-slate-900 text-sm font-semibold focus:outline-none
                                          focus:border-teal focus:bg-white transition-all duration-200
                                          score-input"
                                            oninput="colorScoreInput(this)" required>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer form --}}
            <div class="flex items-center justify-between px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                <p class="text-xs text-slate-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    Pastikan semua nilai telah diisi sebelum menyimpan.
                </p>
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
                           text-white text-sm font-semibold px-6 py-2.5 rounded-xl
                           hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                    <i class="fas fa-save text-xs"></i> Simpan Semua Nilai
                </button>
            </div>
        </div>

    </form>

@endsection

@push('scripts')
    <script>
        /* Warna input berdasarkan nilai */
        function colorScoreInput(el) {
            const v = parseInt(el.value);
            el.classList.remove('border-red-300', 'border-amber-400', 'border-teal');
            if (!el.value) return;
            if (v >= 4) el.classList.add('border-teal');
            else if (v >= 3) el.classList.add('border-amber-400');
            else el.classList.add('border-red-300');
        }
        /* Init warna saat load */
        document.querySelectorAll('.score-input').forEach(el => {
            if (el.value) colorScoreInput(el);
        });
    </script>
@endpush
