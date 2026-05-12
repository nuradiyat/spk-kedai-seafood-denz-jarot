@extends('layouts.app')

@section('title', 'Tambah Kriteria')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">
        {{-- BUTTON --}}
        <div>

            <a href="{{ route('kriteria.index') }}"
            class="inline-flex items-center px-5 py-3 rounded-2xl
                    bg-slate-700 hover:bg-slate-800
                    text-white font-semibold transition">

                ← Kembali

            </a>

        </div><br>

    <h1 class="text-2xl font-bold mb-6">
        Tambah Kriteria
    </h1>

    <form action="{{ route('kriteria.store') }}"
          method="POST">

        @csrf

        @include('pages.kriteria.partials.form')

    </form>

</div>

</body>
</html>

@endsection