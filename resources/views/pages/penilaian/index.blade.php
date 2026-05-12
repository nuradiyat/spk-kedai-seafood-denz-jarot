@extends('layouts.app')

@section('title', 'Data Penilaian')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Data Penilaian
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola proses penilaian karyawan menggunakan metode SAW
            </p>
        </div>

        <a href="{{ route('penilaian.create') }}"
           class="inline-flex items-center justify-center
                  bg-gradient-to-r from-cyan-600 to-blue-700
                  hover:from-cyan-700 hover:to-blue-800
                  text-white font-semibold
                  px-5 py-3 rounded-2xl
                  shadow-lg shadow-cyan-500/20
                  transition duration-200">

            + Input Penilaian

        </a>

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
                            Aksi
                        </th>

                    </tr>

                </thead>

                {{-- BODY TABLE --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($penilaians as $penilaian)

                    <tr class="hover:bg-slate-50 transition">

                        {{-- NO --}}
                        <td class="px-6 py-4 font-semibold text-slate-600">

                            {{ $loop->iteration }}

                        </td>

                        {{-- PERIODE --}}
                        <td class="px-6 py-4">

                            <span class="font-semibold text-slate-800">
                                {{ $penilaian->periode }}
                            </span>

                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-6 py-4 text-slate-600">

                            {{ $penilaian->tanggal_penilaian }}

                        </td>

                        {{-- ADMIN --}}
                        <td class="px-6 py-4">

                            <span class="bg-cyan-100 text-cyan-700
                                         px-3 py-1 rounded-full
                                         text-sm font-semibold">

                                {{ $penilaian->user->name }}

                            </span>

                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4">

                            <div class="flex flex-wrap items-center justify-center gap-2">

                                {{-- DETAIL --}}
                                <a href="{{ route('penilaian.show', $penilaian->id) }}"
                                   class="px-4 py-2 rounded-xl
                                          bg-slate-600 hover:bg-slate-700
                                          text-white text-sm font-semibold
                                          transition">

                                    Detail

                                </a>

                                {{-- PROSES SAW --}}
                                <form action="{{ route('hasil.proses', $penilaian->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Proses perhitungan SAW sekarang?')">

                                    @csrf

                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl
                                                   bg-green-600 hover:bg-green-700
                                                   text-white text-sm font-semibold
                                                   transition">

                                        Proses SAW

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="px-6 py-14 text-center">

                            <div class="flex flex-col items-center">

                                <div class="text-5xl mb-3">
                                    📊
                                </div>

                                <h3 class="text-lg font-bold text-slate-700 mb-1">
                                    Belum Ada Data Penilaian
                                </h3>

                                <p class="text-slate-500 text-sm">
                                    Silakan input penilaian terlebih dahulu
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