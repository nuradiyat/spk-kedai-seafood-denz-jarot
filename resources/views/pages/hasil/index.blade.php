@extends('layouts.app')

@section('title', 'Hasil SAW')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Hasil Perhitungan SAW
            </h1>

            <p class="text-slate-500 mt-1">
                Ranking hasil penilaian karyawan berdasarkan metode SAW
            </p>
        </div>

        <a href="{{ route('hasil.podium') }}"
           class="inline-flex items-center justify-center
                  px-5 py-3 rounded-2xl
                  bg-gradient-to-r from-amber-500 to-orange-500
                  hover:scale-[1.02] hover:shadow-lg
                  transition-all duration-200
                  text-white font-semibold">

            🏆 Lihat Podium

        </a>

    </div>

    {{-- CARD TABLE --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="p-4 text-center font-bold text-slate-700">
                            Ranking
                        </th>

                        <th class="p-4 text-left font-bold text-slate-700">
                            Nama Karyawan
                        </th>

                        <th class="p-4 text-center font-bold text-slate-700">
                            Nilai Akhir
                        </th>

                        <th class="p-4 text-center font-bold text-slate-700">
                            Status Bonus
                        </th>

                        <th class="p-4 text-center font-bold text-slate-700">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($hasils as $hasil)

                    <tr class="border-t hover:bg-slate-50 transition">

                        {{-- RANKING --}}
                        <td class="p-4 text-center">

                            @if($hasil->ranking == 1)

                                <span class="inline-flex items-center justify-center
                                             w-10 h-10 rounded-full
                                             bg-yellow-100 text-yellow-600
                                             font-bold text-lg">

                                    🥇

                                </span>

                            @elseif($hasil->ranking == 2)

                                <span class="inline-flex items-center justify-center
                                             w-10 h-10 rounded-full
                                             bg-slate-200 text-slate-700
                                             font-bold text-lg">

                                    🥈

                                </span>

                            @elseif($hasil->ranking == 3)

                                <span class="inline-flex items-center justify-center
                                             w-10 h-10 rounded-full
                                             bg-orange-100 text-orange-600
                                             font-bold text-lg">

                                    🥉

                                </span>

                            @else

                                <span class="font-bold text-slate-700">
                                    #{{ $hasil->ranking }}
                                </span>

                            @endif

                        </td>

                        {{-- NAMA --}}
                        <td class="p-4">

                            <div class="font-semibold text-slate-800">
                                {{ $hasil->karyawan->nama_karyawan }}
                            </div>

                        </td>

                        {{-- NILAI --}}
                        <td class="p-4 text-center">

                            <span class="font-bold text-blue-600 text-lg">

                                {{ number_format($hasil->nilai_akhir, 3) }}

                            </span>

                        </td>

                        {{-- STATUS --}}
                        <td class="p-4 text-center">

                            @if($hasil->status_bonus == 'Diterima')

                                <span class="inline-flex items-center
                                             px-4 py-2 rounded-full
                                             bg-green-100 text-green-700
                                             text-sm font-semibold">

                                    ✓ Diterima

                                </span>

                            @else

                                <span class="inline-flex items-center
                                             px-4 py-2 rounded-full
                                             bg-red-100 text-red-700
                                             text-sm font-semibold">

                                    ✕ Tidak

                                </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
                        <td class="p-4 text-center">

                            <a href="{{ route('hasil.detail', $hasil->penilaian_id) }}"
                               class="inline-flex items-center
                                      px-4 py-2 rounded-xl
                                      bg-blue-600 hover:bg-blue-700
                                      text-white text-sm font-semibold
                                      transition">

                                Detail

                            </a>

                            <a href="{{ route('hasil.export', $hasil->penilaian_id) }}"
                                class="inline-flex items-center px-3 py-2 rounded-xl
                                        bg-red-600 hover:bg-red-700
                                        text-white text-sm font-semibold transition">

                                    Export PDF

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="p-10 text-center">

                            <div class="flex flex-col items-center">

                                <div class="text-6xl mb-3">
                                    📊
                                </div>

                                <h3 class="text-lg font-bold text-slate-700 mb-1">
                                    Belum Ada Hasil SAW
                                </h3>

                                <p class="text-slate-500 text-sm">
                                    Silakan lakukan proses penilaian terlebih dahulu
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection