@extends('layouts.app')

@section('title', 'Riwayat Penilaian')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Riwayat Penilaian
            </h1>

            <p class="text-slate-500 mt-1">
                Daftar histori hasil penilaian dan perhitungan metode SAW
            </p>
        </div>

    </div>

    {{-- CARD TABLE --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        <div class="overflow-x-auto">

            <table class="w-full">

                {{-- HEADER TABLE --}}
                <thead class="bg-slate-100 text-slate-700">

                    <tr>

                        <th class="px-6 py-4 text-left font-bold">
                            No
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Periode
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Admin
                        </th>

                        <th class="px-6 py-4 text-center font-bold">
                            Jumlah Hasil
                        </th>

                        <th class="px-6 py-4 text-center font-bold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                {{-- BODY TABLE --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($penilaians as $item)

                    <tr class="hover:bg-slate-50 transition">

                        {{-- NO --}}
                        <td class="px-6 py-4 font-semibold text-slate-600">

                            {{ $loop->iteration }}

                        </td>

                        {{-- PERIODE --}}
                        <td class="px-6 py-4">

                            <span class="font-semibold text-slate-800">
                                {{ $item->periode }}
                            </span>

                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-6 py-4 text-slate-600">

                            {{ $item->tanggal_penilaian }}

                        </td>

                        {{-- ADMIN --}}
                        <td class="px-6 py-4">

                            <span class="bg-cyan-100 text-cyan-700
                                         px-3 py-1 rounded-full
                                         text-sm font-semibold">

                                {{ $item->user->name }}

                            </span>

                        </td>

                        {{-- JUMLAH HASIL --}}
                        <td class="px-6 py-4 text-center">

                            <span class="bg-blue-100 text-blue-700
                                         px-3 py-1 rounded-full
                                         text-sm font-semibold">

                                {{ $item->hasilSaws->count() }} Data

                            </span>

                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('riwayat.detail', $item->id) }}"
                                   class="px-4 py-2 rounded-xl
                                          bg-blue-600 hover:bg-blue-700
                                          text-white text-sm font-semibold
                                          transition">

                                    Detail

                                </a>

                                <a href="{{ route('riwayat.export', $item->id) }}"
                                    class="inline-flex items-center px-3 py-2 rounded-xl
                                            bg-red-600 hover:bg-red-700
                                            text-white text-sm font-semibold transition">

                                    Export PDF

                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="px-6 py-14 text-center">

                            <div class="flex flex-col items-center">

                                <div class="text-5xl mb-3">
                                    🕘
                                </div>

                                <h3 class="text-lg font-bold text-slate-700 mb-1">
                                    Belum Ada Riwayat Penilaian
                                </h3>

                                <p class="text-slate-500 text-sm">
                                    Riwayat proses penilaian akan muncul di sini
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