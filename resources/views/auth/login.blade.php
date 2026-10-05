@extends('layouts.guest')

@section('title', 'Masuk')

@php
    $keunggulan = [
        ['icon' => 'chart', 'text' => 'Perhitungan SAW otomatis, tanpa rekap manual'],
        ['icon' => 'shield-check', 'text' => 'Bobot dan rumus terbuka untuk diaudit'],
        ['icon' => 'history', 'text' => 'Riwayat penilaian setiap periode tersimpan'],
    ];
@endphp

@section('content')
<div class="min-h-screen bg-white lg:grid lg:grid-cols-[1fr_1.05fr]">

    {{-- ============================== FORM ============================== --}}
    <div class="relative flex min-h-screen flex-col overflow-hidden px-6 py-8 sm:px-12 lg:px-16 xl:px-24">
        {{-- dekorasi cahaya + pola, sangat halus --}}
        <div class="pointer-events-none absolute -top-28 -left-28 h-72 w-72 rounded-full bg-indigo-50 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-36 -right-24 h-[22rem] w-[22rem] rounded-full bg-sky-50 blur-3xl"></div>
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(rgba(15,23,42,0.045)_1px,transparent_1px)] [background-size:24px_24px] [mask-image:radial-gradient(ellipse_70%_50%_at_50%_0%,black,transparent)]"></div>

        <a href="{{ url('/') }}" class="relative flex items-center gap-3">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-sky-400 via-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/30">
                <x-icon name="fish" class="h-5 w-5" stroke-width="2.25" />
            </span>
            <span class="leading-tight">
                <span class="block text-base font-extrabold tracking-tight text-slate-900">Denz Jarot</span>
                <span class="block text-[11px] font-medium text-slate-500">Sistem Pendukung Keputusan</span>
            </span>
        </a>

        <div class="relative flex flex-1 items-center py-10">
            <div class="w-full max-w-sm">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-100">
                    <x-icon name="chart" class="h-3.5 w-3.5" /> Bonus Karyawan · Metode SAW
                </span>

                <h1 class="mt-5 text-3xl font-bold tracking-tight text-slate-900">Selamat datang kembali</h1>
                <p class="mt-2 text-sm leading-relaxed text-slate-500">
                    Masuk untuk mengelola penilaian dan hasil perhitungan bonus karyawan berdasarkan kriteria dan bobot
                    yang Anda tentukan.
                </p>

                <form method="POST" action="{{ route('login.process') }}" class="mt-8 space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email</label>
                        <div class="group relative">
                            <x-icon name="mail" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400 transition-colors group-focus-within:text-indigo-500" />
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                   autocomplete="username" autofocus placeholder="nama@perusahaan.com"
                                   class="block h-11 w-full rounded-xl border border-slate-200 bg-white pl-11 pr-3.5 text-sm text-slate-900 shadow-sm shadow-slate-900/[0.04] transition placeholder:text-slate-400 hover:border-slate-300 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                        </div>
                        @error('email')
                            <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-rose-600">
                                <x-icon name="x-circle" class="h-3.5 w-3.5" /> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Kata Sandi</label>
                        <div class="group relative">
                            <x-icon name="lock" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400 transition-colors group-focus-within:text-indigo-500" />
                            <input id="password" name="password" type="password" required
                                   autocomplete="current-password" placeholder="••••••••"
                                   class="block h-11 w-full rounded-xl border border-slate-200 bg-white pl-11 pr-3.5 text-sm text-slate-900 shadow-sm shadow-slate-900/[0.04] transition placeholder:text-slate-400 hover:border-slate-300 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                        </div>
                        @error('password')
                            <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-rose-600">
                                <x-icon name="x-circle" class="h-3.5 w-3.5" /> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    @if ($errors->any())
                        <p role="alert" class="flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-3.5 py-2.5 text-sm font-medium text-rose-700">
                            <x-icon name="x-circle" class="h-4 w-4 shrink-0" />
                            {{ $errors->first() }}
                        </p>
                    @endif

                    <button type="submit"
                            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm shadow-indigo-600/25 transition hover:bg-indigo-700 active:scale-[0.99]">
                        Masuk <x-icon name="arrow-right" class="h-4 w-4" />
                    </button>

                    <p class="text-xs leading-relaxed text-slate-400">
                        Akun dibuat oleh administrator sistem. Hubungi tim IT bila mengalami kendala saat masuk.
                    </p>
                </form>
            </div>
        </div>

        <p class="relative text-xs text-slate-400">© {{ date('Y') }} Denz Jarot · Sistem Pendukung Keputusan Bonus Karyawan</p>
    </div>

    {{-- ============================ PANEL VISUAL ============================ --}}
    <div class="relative hidden overflow-hidden bg-gradient-to-b from-slate-100 to-indigo-100 lg:block">
        <div class="pointer-events-none absolute -top-36 -left-20 h-[28rem] w-[28rem] rounded-full bg-indigo-200/60 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-44 -right-24 h-[26rem] w-[26rem] rounded-full bg-sky-200/50 blur-3xl"></div>

        <img src="{{ asset('images/login.jpg') }}" alt="Ruang kerja administrator"
             class="absolute inset-0 h-full w-full object-cover object-center saturate-[0.95]">
        <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/55 to-indigo-200/75"></div>
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(rgba(15,23,42,0.06)_1px,transparent_1px)] [background-size:22px_22px]"></div>
        <div class="pointer-events-none absolute -right-14 top-1/3 h-80 w-80 rounded-full border border-slate-300/30"></div>
        <div class="pointer-events-none absolute -right-14 top-1/3 h-80 w-80 scale-[0.65] rounded-full border border-slate-300/40"></div>

        <div class="relative flex h-full flex-col justify-between px-12 py-14 xl:px-16">
            <span class="inline-flex w-fit items-center gap-2 rounded-2xl bg-white/80 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-white/90 backdrop-blur">
                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                Metode Simple Additive Weighting (SAW)
            </span>

            <div class="max-w-lg">
                <h2 class="text-4xl font-bold leading-[1.15] tracking-tight text-slate-900 xl:text-[42px]">
                    Setiap bonus berhak dihitung secara objektif.
                </h2>
                <p class="mt-4 max-w-md text-base leading-relaxed text-slate-600">
                    Satu tempat untuk menilai karyawan, menormalkan matriks, dan menetapkan penerima bonus tanpa
                    perasaan semata.
                </p>

                <ul class="mt-8 space-y-3.5">
                    @foreach ($keunggulan as $k)
                        <li class="flex items-center gap-3 text-sm font-medium text-slate-700">
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-white text-indigo-600 shadow-sm ring-1 ring-inset ring-slate-200/70">
                                <x-icon :name="$k['icon']" class="h-4 w-4" />
                            </span>
                            {{ $k['text'] }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div></div>
        </div>

        <div class="absolute bottom-0 left-0 h-px w-full bg-gradient-to-r from-transparent via-indigo-300 to-transparent"></div>
    </div>
</div>
@endsection