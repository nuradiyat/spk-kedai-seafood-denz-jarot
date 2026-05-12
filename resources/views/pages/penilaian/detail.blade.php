@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('content')

<div class="space-y-6">
    {{-- BUTTON --}}
    <div>

        <a href="{{ route('penilaian.index') }}"
           class="inline-flex items-center px-5 py-3 rounded-2xl
                  bg-slate-700 hover:bg-slate-800
                  text-white font-semibold transition">

            ← Kembali

        </a>

    </div>

    {{-- HEADER --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

        <h1 class="text-2xl font-bold text-slate-800">
            Detail Penilaian
        </h1>

        <div class="mt-4 space-y-2 text-slate-600">

            <p>
                <span class="font-semibold">Periode:</span>
                {{ $penilaian->periode }}
            </p>

            <p>
                <span class="font-semibold">Tanggal:</span>
                {{ $penilaian->tanggal_penilaian }}
            </p>

            <p>
                <span class="font-semibold">Admin:</span>
                {{ $penilaian->user->name }}
            </p>

        </div>

    </div>

    {{-- TABEL NILAI --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="p-6 border-b border-slate-100">

            <h2 class="text-lg font-bold text-slate-800">
                Data Penilaian Karyawan
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="p-4 text-left font-semibold text-slate-600">
                            Nama Karyawan
                        </th>

                        <th class="p-4 text-left font-semibold text-slate-600">
                            Kriteria
                        </th>

                        <th class="p-4 text-left font-semibold text-slate-600">
                            Nilai
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($penilaian->detailPenilaians as $detail)

                    <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                        <td class="p-4 text-slate-700 font-medium">

                            {{ $detail->karyawan->nama_karyawan }}

                        </td>

                        <td class="p-4 text-slate-600">

                            {{ $detail->kriteria->nama_kriteria }}

                        </td>

                        <td class="p-4">

                            <span class="px-4 py-2 rounded-xl bg-blue-100 text-blue-700 text-sm font-semibold">

                                {{ $detail->nilai }}

                            </span>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection