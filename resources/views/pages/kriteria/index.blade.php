@extends('layouts.app')

@section('title', 'Data Kriteria')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Data Kriteria
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola data kriteria dan bobot penilaian metode SAW
            </p>
        </div>

        <a href="{{ route('kriteria.create') }}"
           class="inline-flex items-center justify-center
                  bg-gradient-to-r from-cyan-600 to-blue-700
                  hover:from-cyan-700 hover:to-blue-800
                  text-white font-semibold
                  px-5 py-3 rounded-2xl
                  shadow-lg shadow-cyan-500/20
                  transition duration-200">

            + Tambah Kriteria

        </a>

    </div>

    {{-- CARD TABLE --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100 text-slate-700">

                    <tr>

                        <th class="px-6 py-4 text-left font-bold">
                            Kode
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Nama Kriteria
                        </th>

                        <th class="px-6 py-4 text-center font-bold">
                            Bobot
                        </th>

                        <th class="px-6 py-4 text-center font-bold">
                            Jenis
                        </th>

                        <th class="px-6 py-4 text-center font-bold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($kriterias as $item)

                    <tr class="hover:bg-slate-50 transition">

                        {{-- KODE --}}
                        <td class="px-6 py-4">

                            <span class="font-bold text-cyan-700">
                                {{ $item->kode }}
                            </span>

                        </td>

                        {{-- NAMA --}}
                        <td class="px-6 py-4 font-medium text-slate-700">

                            {{ $item->nama_kriteria }}

                        </td>

                        {{-- BOBOT --}}
                        <td class="px-6 py-4 text-center">

                            <span class="bg-blue-100 text-blue-700
                                         px-3 py-1 rounded-full
                                         text-sm font-semibold">

                                {{ number_format($item->bobot, 2) }}

                            </span>

                        </td>

                        {{-- JENIS --}}
                        <td class="px-6 py-4 text-center">

                            @if($item->jenis == 'benefit')

                                <span class="bg-green-100 text-green-700
                                             px-3 py-1 rounded-full
                                             text-sm font-semibold">

                                    Benefit

                                </span>

                            @else

                                <span class="bg-red-100 text-red-700
                                             px-3 py-1 rounded-full
                                             text-sm font-semibold">

                                    Cost

                                </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center justify-center gap-2">

                                {{-- EDIT --}}
                                <a href="{{ route('kriteria.edit', $item->id) }}"
                                   class="px-4 py-2 rounded-xl
                                          bg-amber-400 hover:bg-amber-500
                                          text-white text-sm font-semibold
                                          transition">

                                    Edit

                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('kriteria.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl
                                                   bg-red-500 hover:bg-red-600
                                                   text-white text-sm font-semibold
                                                   transition">

                                        Hapus

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
                                    📋
                                </div>

                                <h3 class="text-lg font-bold text-slate-700 mb-1">
                                    Belum Ada Data Kriteria
                                </h3>

                                <p class="text-slate-500 text-sm">
                                    Silakan tambahkan data kriteria terlebih dahulu
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