@extends('layouts.app')

@section('title', 'Detail Perhitungan SAW')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="p-6">

    <div class="bg-white rounded-xl shadow p-6">
        {{-- BUTTON --}}
        <div>

            <a href="{{ route('hasil.index') }}"
            class="inline-flex items-center px-5 py-3 rounded-2xl
                    bg-slate-700 hover:bg-slate-800
                    text-white font-semibold transition">

                ← Kembali

            </a>

        </div><br>

        <h1 class="text-2xl font-bold mb-2">
            Detail Perhitungan SAW
        </h1>

        <p class="text-gray-500 mb-6">
            Periode:
            {{ $penilaian->periode }}
        </p>

        {{-- ===================================== --}}
        {{-- MATRIX AWAL --}}
        {{-- ===================================== --}}

        <h2 class="text-xl font-bold mb-3">
            Matrix Awal
        </h2>

        <div class="overflow-x-auto mb-8">

            <table class="w-full border">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="border p-3">
                            Karyawan
                        </th>

                        @foreach($hasil['kriterias'] as $kriteria)

                        <th class="border p-3">
                            {{ $kriteria->kode }}
                        </th>

                        @endforeach

                    </tr>

                </thead>

                <tbody>

                    @foreach($hasil['karyawans'] as $karyawan)

                    <tr>

                        <td class="border p-3 font-medium">
                            {{ $karyawan->nama_karyawan }}
                        </td>

                        @foreach($hasil['kriterias'] as $kriteria)

                        <td class="border p-3 text-center">

                            {{ $hasil['nilai_awal'][$karyawan->id][$kriteria->id] }}

                        </td>

                        @endforeach

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- ===================================== --}}
        {{-- MAX & MIN --}}
        {{-- ===================================== --}}

        <h2 class="text-xl font-bold mb-3">
            Nilai Maximum & Minimum
        </h2>

        <div class="overflow-x-auto mb-8">

            <table class="w-full border">

                <thead class="bg-gray-100">

                    <tr>
                        <th class="border p-3">Kriteria</th>
                        <th class="border p-3">Jenis</th>
                        <th class="border p-3">Max</th>
                        <th class="border p-3">Min</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($hasil['kriterias'] as $kriteria)

                    <tr>

                        <td class="border p-3 text-center">
                            {{ $kriteria->kode }}
                        </td>

                        <td class="border p-3 text-center capitalize">
                            {{ $kriteria->jenis }}
                        </td>

                        <td class="border p-3 text-center">
                            {{ $hasil['max'][$kriteria->id] }}
                        </td>

                        <td class="border p-3 text-center">
                            {{ $hasil['min'][$kriteria->id] }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">

            <h3 class="font-bold text-blue-700 mb-2">
                Rumus Normalisasi SAW
            </h3>

            <p class="text-sm text-blue-600">
                Benefit = Nilai / Max <br>
                Cost = Min / Nilai
            </p>

        </div>

        {{-- ===================================== --}}
        {{-- NORMALISASI --}}
        {{-- ===================================== --}}

        <h2 class="text-xl font-bold mb-3">
            Normalisasi
        </h2>

        <div class="overflow-x-auto mb-8">

            <table class="w-full border">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="border p-3">
                            Karyawan
                        </th>

                        @foreach($hasil['kriterias'] as $kriteria)

                        <th class="border p-3">
                            {{ $kriteria->kode }}
                        </th>

                        @endforeach

                    </tr>

                </thead>

                <tbody>

                    @foreach($hasil['karyawans'] as $karyawan)

                    <tr>

                        <td class="border p-3 font-medium">
                            {{ $karyawan->nama_karyawan }}
                        </td>

                        @foreach($hasil['kriterias'] as $kriteria)

                        <td class="border p-3 text-center">

                            {{ number_format(
                                $hasil['normalisasi'][$karyawan->id][$kriteria->id],
                                3
                            ) }}

                        </td>

                        @endforeach

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- ===================================== --}}
        {{-- BOBOT KRITERIA --}}
        {{-- ===================================== --}}

        <h2 class="text-xl font-bold mb-3">
            Bobot Kriteria
        </h2>

        <div class="overflow-x-auto mb-8">

            <table class="w-full border">

                <thead class="bg-gray-100">

                    <tr>
                        <th class="border p-3">Kode</th>
                        <th class="border p-3">Nama Kriteria</th>
                        <th class="border p-3">Bobot</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($hasil['kriterias'] as $kriteria)

                    <tr>

                        <td class="border p-3 text-center">
                            {{ $kriteria->kode }}
                        </td>

                        <td class="border p-3">
                            {{ $kriteria->nama_kriteria }}
                        </td>

                        <td class="border p-3 text-center">

                            {{ $kriteria->bobot }}

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- ===================================== --}}
        {{-- MATRIX TERBOBOT --}}
        {{-- ===================================== --}}

        <h2 class="text-xl font-bold mb-3">
            Matrix Terbobot
        </h2>

        <div class="overflow-x-auto mb-8">

            <table class="w-full border">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="border p-3">
                            Karyawan
                        </th>

                        @foreach($hasil['kriterias'] as $kriteria)

                        <th class="border p-3">
                            {{ $kriteria->kode }}
                        </th>

                        @endforeach

                    </tr>

                </thead>

                <tbody>

                    @foreach($hasil['karyawans'] as $karyawan)

                    <tr>

                        <td class="border p-3 font-medium">
                            {{ $karyawan->nama_karyawan }}
                        </td>

                        @foreach($hasil['kriterias'] as $kriteria)

                        <td class="border p-3 text-center">

                            {{ number_format(
                                $hasil['terbobot'][$karyawan->id][$kriteria->id],
                                3
                            ) }}

                        </td>

                        @endforeach

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- ===================================== --}}
        {{-- HASIL RANKING AKHIR--}}
        {{-- ===================================== --}}

        <h2 class="text-xl font-bold mb-3">
            Hasil Ranking Akhir
        </h2>

        <table class="w-full border">

            <thead class="bg-gray-100">

                <tr>

                    <th class="border p-3">Ranking</th>
                    <th class="border p-3">Karyawan</th>
                    <th class="border p-3">Nilai Akhir</th>

                </tr>

            </thead>

            <tbody>

                @php $rank = 1; @endphp

                @foreach($hasil['ranking'] as $karyawanId => $nilai)

                <tr>

                    <td class="border p-3 text-center">
                        {{ $rank++ }}
                    </td>

                    <td class="border p-3">

                        {{
                            $hasil['karyawans']
                            ->firstWhere('id', $karyawanId)
                            ->nama_karyawan
                        }}

                    </td>

                    <td class="border p-3">

                        {{ number_format($nilai, 3) }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

</body>
</html>

@endsection