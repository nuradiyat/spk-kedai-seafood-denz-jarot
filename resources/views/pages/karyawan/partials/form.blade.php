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
        <input type="text" name="nama" value="{{ old('nama', $karyawan->nama ?? '') }}"
            placeholder="Nama lengkap karyawan"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                      text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                      transition-all @error('nama') border-red-400 @enderror"
            required>
        @error('nama')
            <p class="text-red-500 text-xs mt-1.5"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
        @enderror
    </div>

    {{-- NIK --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">NIK / ID</label>
        <input type="text" name="nik" value="{{ old('nik', $karyawan->nik ?? '') }}" placeholder="cth: KRY-001"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                      text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white transition-all">
        @error('nik')
            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    {{-- Posisi --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
            Posisi / Jabatan <span class="text-red-400">*</span>
        </label>
        <input type="text" name="posisi" value="{{ old('posisi', $karyawan->posisi ?? '') }}"
            placeholder="cth: Kasir, Pengolah, Pelayan"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                      text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                      transition-all @error('posisi') border-red-400 @enderror"
            required>
        @error('posisi')
            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tanggal Masuk --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Tanggal Masuk</label>
        <input type="date" name="tgl_masuk"
            value="{{ old('tgl_masuk', isset($karyawan) && $karyawan->tgl_masuk ? \Carbon\Carbon::parse($karyawan->tgl_masuk)->format('Y-m-d') : '') }}"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                      text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white transition-all">
    </div>

    {{-- No HP --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">No. HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $karyawan->no_hp ?? '') }}"
            placeholder="cth: 0812-3456-7890"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                      text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white transition-all">
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
            Status <span class="text-red-400">*</span>
        </label>
        <select name="status"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                       text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                       transition-all cursor-pointer">
            @foreach (['aktif' => 'Aktif', 'percobaan' => 'Masa Percobaan', 'tidak_aktif' => 'Tidak Aktif'] as $val => $lbl)
                <option value="{{ $val }}"
                    {{ old('status', $karyawan->status ?? 'aktif') === $val ? 'selected' : '' }}>
                    {{ $lbl }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Alamat --}}
    <div class="sm:col-span-2">
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Alamat</label>
        <textarea name="alamat" rows="3" placeholder="Alamat lengkap karyawan..."
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                         text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                         transition-all resize-none">{{ old('alamat', $karyawan->alamat ?? '') }}</textarea>
    </div>

</div>
