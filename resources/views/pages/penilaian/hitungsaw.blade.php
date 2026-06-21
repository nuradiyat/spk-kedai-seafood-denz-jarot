{{--
================================================================
pages/penilaian/hitungsaw.blade.php

FUNGSI  : Form edit penilaian & simpan perhitungan SAW
          Mendapatkan input update nilai dari penilai, kemudian menjalankan 
          perhitungan SAW untuk mendapatkan nilai akhir setiap karyawan

CONTROLLER: HitungSaw@show
METHODS   : prosesPenilaian() -> untuk status 'belum_diperoses'
            prosesUlangPenilaian() -> untuk status 'hitung_ulang_saw'

STATUS PERHITUNGAN:
- 'belum_diproses' => Tombol "Hitung Saw" untuk perhitungan pertama kali
- 'hitung_ulang_saw' => Tombol "Hitung Ulang Saw" jika ada perubahan data nilai
================================================================
--}}
@extends('layouts.app')

@section('title', 'Hitung Saw')
@section('page-title', 'Hitung Saw')
@section('page-subtitle', 'Simpan Perhitungan saw')

@section('content')

    {{-- Back button + Judul Halaman --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('penilaian.index') }}"
            class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500
              flex items-center justify-center hover:bg-slate-50 transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="font-heading font-bold text-ocean text-xl">Hitung penilaian Saw</h2>
            <p class="text-slate-400 text-sm mt-0.5">Simpan Perhitungan saw</p>
        </div>
    </div>

    {{-- 
        Form Penilaian dengan aksi dinamis berdasarkan status perhitungan
        
        Status dan aksi yang dihandle:
        - 'belum_diproses' => submit ke hitungsaw.proses (jalankan perhitungan SAW)
        - 'hitung_ulang_saw' => submit ke hitungsaw.hitung-ulang (ulang perhitungan ada update data)
    --}}
    <form id="formPenilaian" method="POST" action="{{ $formAction }}">
        @csrf
        @method('PUT')

        {{-- Input Form Nilai Karyawan per Kriteria --}}
        @include('pages.penilaian.partials.form')

        {{-- Action Buttons (Hitung/Simpan dan Batal) --}}
        <div class="flex justify-end items-center gap-3 mt-6 border-t border-slate-100 pt-6">
            
            @if ($penilaian->status_perhitungan === 'belum_diproses')
                {{-- Tombol Hitung Saw (untuk perhitungan pertama kali) --}}
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
                    text-white text-sm font-semibold px-6 py-2.5 rounded-xl
                    hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                    <i class="fas fa-save text-xs"></i>
                    Hitung Saw
                </button>
            @else
                {{-- Tombol Hitung Ulang Saw (jika status hitung_ulang_saw atau sudah_diproses) --}}
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean to-ocean-lt
                    text-white text-sm font-semibold px-6 py-2.5 rounded-xl
                    hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                    <i class="fas fa-save text-xs"></i>
                    Hitung Ulang Saw
                </button>
            @endif

            {{-- Tombol Batal --}}
            <a href="{{ route('penilaian.index') }}"
                class="text-sm text-slate-500 border border-slate-200 bg-white
                px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                Batal
            </a>

        </div>

    </form>

@endsection
