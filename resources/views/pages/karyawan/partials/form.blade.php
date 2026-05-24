{{-- 
================================================================
pages/karyawan/partials/form.blade.php
Partial reusable field form karyawan.
Dipakai oleh: create.blade.php dan edit.blade.php
$karyawan: optional (untuk mode edit)
================================================================
--}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

    {{-- Nama Lengkap --}}
    <div class="sm:col-span-2">
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
            Nama Lengkap <span class="text-red-400">*</span>
        </label>
        <input type="text" name="nama_karyawan" value="{{ old('nama_karyawan', $karyawan->nama_karyawan ?? '') }}"
            placeholder="Nama lengkap karyawan"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                   text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                   transition-all @error('nama_karyawan') border-red-400 @enderror"
            required>

        @error('nama_karyawan')
            <p class="text-red-500 text-xs mt-1.5">
                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
            </p>
        @enderror
    </div>

    {{-- Jabatan --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
            Posisi / Jabatan
        </label>

        <input type="text" name="jabatan" value="{{ old('jabatan', $karyawan->jabatan ?? '') }}"
            placeholder="cth: Kasir, Pengolah, Pelayan"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                   text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                   transition-all @error('jabatan') border-red-400 @enderror">

        @error('jabatan')
            <p class="text-red-500 text-xs mt-1.5">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Tanggal Masuk --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
            Tanggal Masuk
        </label>

        <input type="date" name="tanggal_masuk"
            value="{{ old('tanggal_masuk', isset($karyawan) && $karyawan->tanggal_masuk ? \Carbon\Carbon::parse($karyawan->tanggal_masuk)->format('Y-m-d') : '') }}"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                   text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                   transition-all">
    </div>

    {{-- Status --}}
    <div class="sm:col-span-2">
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
            Status <span class="text-red-400">*</span>
        </label>

        <select name="status"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                   text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                   transition-all cursor-pointer">

            @foreach (['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'] as $val => $lbl)
                <option value="{{ $val }}"
                    {{ old('status', $karyawan->status ?? 'aktif') === $val ? 'selected' : '' }}>
                    {{ $lbl }}
                </option>
            @endforeach

        </select>

        @error('status')
            <p class="text-red-500 text-xs mt-1.5">
                {{ $message }}
            </p>
        @enderror
    </div>

</div>
