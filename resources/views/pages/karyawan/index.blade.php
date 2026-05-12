@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Data Karyawan
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola seluruh data karyawan perusahaan
            </p>
        </div>

        <a href="{{ route('karyawan.create') }}"
           class="inline-flex items-center justify-center
                  px-5 py-3 rounded-2xl
                  bg-gradient-to-r from-cyan-500 to-blue-600
                  hover:shadow-lg hover:shadow-cyan-500/30
                  text-white font-semibold transition duration-200">

            + Tambah Karyawan

        </a>

    </div>

    {{-- CARD TABLE --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                {{-- HEAD --}}
                <thead class="bg-slate-100">

                    <tr class="text-slate-700">

                        <th class="px-6 py-4 text-left font-semibold">
                            No
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Nama Karyawan
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Jabatan
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($karyawans as $item)

                    <tr class="hover:bg-slate-50 transition">

                        {{-- NO --}}
                        <td class="px-6 py-5 text-slate-600">
                            {{ $loop->iteration }}
                        </td>

                        {{-- NAMA --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-4">

                                {{-- AVATAR --}}
                                <div class="w-11 h-11 rounded-2xl
                                            bg-gradient-to-br from-cyan-500 to-blue-600
                                            flex items-center justify-center
                                            text-white font-bold">

                                    {{ strtoupper(substr($item->nama_karyawan, 0, 1)) }}

                                </div>

                                <div>

                                    <h3 class="font-semibold text-slate-800">
                                        {{ $item->nama_karyawan }}
                                    </h3>

                                    <p class="text-sm text-slate-400">
                                        ID Karyawan #{{ $item->id }}
                                    </p>

                                </div>

                            </div>

                        </td>

                        {{-- JABATAN --}}
                        <td class="px-6 py-5 text-slate-600">
                            {{ $item->jabatan ?? '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-5 text-center">

                            @if($item->status == 'aktif')

                                <span class="inline-flex items-center
                                             px-4 py-2 rounded-full
                                             bg-green-100 text-green-700
                                             text-sm font-semibold">

                                    Aktif

                                </span>

                            @else

                                <span class="inline-flex items-center
                                             px-4 py-2 rounded-full
                                             bg-red-100 text-red-700
                                             text-sm font-semibold">

                                    Nonaktif

                                </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center justify-center gap-2">

                                {{-- DETAIL --}}
                                <a href="{{ route('karyawan.show', $item->id) }}"
                                   class="px-4 py-2 rounded-xl
                                          bg-cyan-500 hover:bg-cyan-600
                                          text-white text-sm font-semibold
                                          transition">

                                    Detail

                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('karyawan.edit', $item->id) }}"
                                   class="px-4 py-2 rounded-xl
                                          bg-amber-400 hover:bg-amber-500
                                          text-white text-sm font-semibold
                                          transition">

                                    Edit

                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('karyawan.destroy', $item->id) }}"
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

                                <div class="text-5xl mb-4">
                                    📂
                                </div>

                                <h3 class="text-lg font-semibold text-slate-700">
                                    Belum Ada Data Karyawan
                                </h3>

                                <p class="text-slate-400 mt-1">
                                    Silakan tambahkan data karyawan terlebih dahulu
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