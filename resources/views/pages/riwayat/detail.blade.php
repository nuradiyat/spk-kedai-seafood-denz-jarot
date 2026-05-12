@extends('layouts.app')

@section('title', 'Detail Riwayat')

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

            <a href="{{ route('riwayat.index') }}"
            class="inline-flex items-center px-5 py-3 rounded-2xl
                    bg-slate-700 hover:bg-slate-800
                    text-white font-semibold transition">

                ← Kembali

            </a>

        </div><br>

        {{-- HEADER --}}
        <div class="mb-6">

            <h1 class="text-2xl font-bold">
                Detail Riwayat Penilaian
            </h1>

            <div class="mt-3 text-sm text-gray-600 space-y-1">

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

        {{-- TABEL HASIL --}}
        <div class="overflow-x-auto">

            <table class="w-full border">

                <thead class="bg-gray-100">

                    <tr>
                        <th class="border p-3">Ranking</th>
                        <th class="border p-3">Nama Karyawan</th>
                        <th class="border p-3">Nilai Akhir</th>
                        <th class="border p-3">Status Bonus</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($penilaian->hasilSaws->sortBy('ranking') as $hasil)

                    <tr>

                        <td class="border p-3 text-center font-bold">
                            {{ $hasil->ranking }}
                        </td>

                        <td class="border p-3">
                            {{ $hasil->karyawan->nama_karyawan }}
                        </td>

                        <td class="border p-3 text-center">

                            {{ number_format($hasil->nilai_akhir, 4) }}

                        </td>

                        <td class="border p-3 text-center">

                            @if($hasil->status_bonus == 'Diterima')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                    Diterima
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                    Tidak
                                </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>

@endsection