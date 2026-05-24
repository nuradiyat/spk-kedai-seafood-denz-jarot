{{-- 
================================================================
components/tables/hasil-table.blade.php
Tabel hasil ranking SAW
================================================================
--}}

<div class="overflow-x-auto">

    <table class="w-full text-sm">

        {{-- HEADER --}}
        <thead class="bg-slate-50 border-b border-slate-200">

            <tr>

                <th class="text-left px-5 py-3 text-slate-400 text-xs uppercase">
                    No
                </th>

                <th class="text-left px-3 py-3 text-slate-400 text-xs uppercase">
                    Periode
                </th>

                <th class="text-center px-3 py-3 text-slate-400 text-xs uppercase">
                    Total Karyawan
                </th>

                <th class="text-left px-3 py-3 text-slate-400 text-xs uppercase">
                    Ranking 1
                </th>

                <th class="text-left px-3 py-3 text-slate-400 text-xs uppercase">
                    Tanggal
                </th>

                <th class="text-center px-3 py-3 text-slate-400 text-xs uppercase">
                    Aksi
                </th>

            </tr>

        </thead>

        {{-- BODY --}}
        <tbody>

            @forelse($daftarHasilSaw as $index => $penilaian)
                @php

                    /*
                    |----------------------------------------------------------
                    | Ambil ranking 1
                    |----------------------------------------------------------
                    */

                    $ranking1 = $penilaian->hasilSaws->where('ranking', 1)->first();

                @endphp

                <tr class="border-b border-slate-100">

                    {{-- Nomor --}}
                    <td class="px-5 py-4 text-slate-500">

                        {{ $daftarHasilSaw->firstItem() + $index }}

                    </td>

                    {{-- Periode --}}
                    <td class="px-3 py-4">

                        <div class="font-semibold text-ocean">

                            {{ $penilaian->periode }}

                        </div>

                    </td>

                    {{-- Total Karyawan --}}
                    <td class="px-3 py-4 text-center">

                        <span
                            class="inline-flex items-center justify-center
                            w-9 h-9 rounded-xl bg-ocean/10 text-ocean font-bold">

                            {{ $penilaian->hasil_saws_count }}

                        </span>

                    </td>

                    {{-- Ranking 1 --}}
                    <td class="px-3 py-4">

                        @if ($ranking1)
                            <div class="flex items-center gap-3">

                                <div
                                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-ocean to-ocean-lt
                                    text-white flex items-center justify-center font-bold">

                                    {{ strtoupper(substr($ranking1->karyawan->nama_karyawan, 0, 2)) }}

                                </div>

                                <div>

                                    <p class="font-semibold text-slate-700">

                                        {{ $ranking1->karyawan->nama_karyawan }}

                                    </p>

                                    <p class="text-xs text-teal-600">

                                        {{ number_format($ranking1->nilai_akhir, 4) }}

                                    </p>

                                </div>

                            </div>
                        @else
                            <span class="text-slate-400">

                                Belum diproses

                            </span>
                        @endif

                    </td>

                    {{-- Tanggal --}}
                    <td class="px-3 py-4 text-slate-500 text-sm">

                        {{ $penilaian->created_at->translatedFormat('d M Y') }}

                    </td>

                    {{-- AKSI --}}
                    <td class="px-3 py-4">

                        <div class="flex items-center justify-center gap-2">

                            {{-- Tombol proses SAW --}}
                            <form action="{{ route('hasil.proses', $penilaian->id) }}" method="POST">

                                @csrf

                                <button type="submit"
                                    class="w-9 h-9 rounded-xl bg-teal-500 text-white
                                    hover:bg-teal-600 transition-colors"
                                    title="Proses SAW">

                                    <i class="fas fa-calculator text-xs"></i>

                                </button>

                            </form>

                            {{-- Detail hasil --}}
                            <a href="{{ route('hasil.detail', $penilaian->id) }}"
                                class="w-9 h-9 rounded-xl bg-ocean/10 text-ocean
                                hover:bg-ocean/20 transition-colors
                                flex items-center justify-center"
                                title="Detail">

                                <i class="fas fa-trophy text-xs"></i>

                            </a>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="py-20 text-center">

                        <i class="fas fa-trophy text-5xl text-slate-200 mb-4"></i>

                        <p class="text-slate-500 font-medium">
                            Belum ada hasil SAW
                        </p>

                        <p class="text-slate-400 text-sm mt-1">
                            Silakan input penilaian terlebih dahulu
                        </p>

                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>

</div>

{{-- Pagination --}}
@if ($daftarHasilSaw->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">

        {{ $daftarHasilSaw->links() }}

    </div>
@endif
