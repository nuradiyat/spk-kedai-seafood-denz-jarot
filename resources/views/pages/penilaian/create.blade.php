@extends('layouts.app')

@section('title', 'Input Penilaian')

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

            <a href="{{ route('penilaian.index') }}"
            class="inline-flex items-center px-5 py-3 rounded-2xl
                    bg-slate-700 hover:bg-slate-800
                    text-white font-semibold transition">

                ← Kembali

            </a>

        </div><br>

        <h1 class="text-2xl font-bold mb-6">
            Input Penilaian Karyawan
        </h1>

        <form action="{{ route('penilaian.store') }}"
              method="POST">

            @csrf

            {{-- PERIODE --}}
            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Periode Penilaian
                </label>

                <input type="text"
                       name="periode"
                       placeholder="Contoh: Mei 2026"
                       class="w-full border rounded-lg px-4 py-2"
                       required>

            </div>

            {{-- TABLE PENILAIAN --}}
            <div class="overflow-x-auto">

                <table class="w-full border">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="border p-3">
                                Nama Karyawan
                            </th>

                            @foreach($kriterias as $kriteria)

                                <th class="border p-3">
                                    {{ $kriteria->kode }}
                                </th>

                            @endforeach

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($karyawans as $karyawan)

                        <tr>

                            <td class="border p-3 font-medium">
                                {{ $karyawan->nama_karyawan }}
                            </td>

                            @foreach($kriterias as $kriteria)

                            <td class="border p-2">

                                <select
                                       name="nilai[{{ $karyawan->id }}][{{ $kriteria->id }}]"
                                       class="w-full border rounded px-2 py-1"
                                       required>

                                       <option value="">Pilih</option>

                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                       <option value="4">4</option>
                                       <option value="5">5</option>
                                       
                                </select>

                            </td>

                            @endforeach

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- BUTTON --}}
            <div class="mt-6">

                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg">

                    Simpan Penilaian

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>

@endsection