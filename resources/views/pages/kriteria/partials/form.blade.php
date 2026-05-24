{{-- 
================================================================
pages/kriteria/partials/form.blade.php
Partial reusable field form kriteria.
Dipakai oleh: create.blade.php dan edit.blade.php
$kriteria: optional (untuk mode edit)
================================================================
--}}

{{-- Kode Kriteria --}}
<div class="mb-5">
    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
        Kode Kriteria <span class="text-red-400">*</span>
    </label>

    <input type="text" name="kode" value="{{ old('kode', $kriteria->kode ?? '') }}" placeholder="cth: C1, C2, C3 ..."
        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
               text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
               transition-all @error('kode') border-red-400 @enderror"
        required>

    @error('kode')
        <p class="text-red-500 text-xs mt-1.5">
            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
        </p>
    @enderror

    <p class="text-xs text-slate-400 mt-1">
        Format: C1, C2, dst. Urutan menentukan tampilan.
    </p>
</div>

{{-- Nama Kriteria --}}
<div class="mb-5">
    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
        Nama Kriteria <span class="text-red-400">*</span>
    </label>

    <input type="text" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria ?? '') }}"
        placeholder="cth: Kehadiran, Produktivitas Kerja ..."
        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
               text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
               transition-all @error('nama_kriteria') border-red-400 @enderror"
        required>

    @error('nama_kriteria')
        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
    @enderror
</div>

{{-- Jenis / Tipe Kriteria --}}
<div class="mb-5">
    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
        Tipe Kriteria <span class="text-red-400">*</span>
    </label>

    <div class="grid grid-cols-2 gap-3">

        {{-- Benefit --}}
        <label
            class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
            {{ old('jenis', $kriteria->jenis ?? 'benefit') === 'benefit'
                ? 'border-teal bg-teal-bg'
                : 'border-slate-200 bg-sand hover:border-slate-300' }}">

            <input type="radio" name="jenis" value="benefit"
                {{ old('jenis', $kriteria->jenis ?? 'benefit') === 'benefit' ? 'checked' : '' }} class="accent-teal"
                onchange="updateJenisStyle(this)">

            <div>
                <p class="text-sm font-semibold text-slate-800">Benefit</p>
                <p class="text-xs text-slate-400">
                    Nilai lebih besar = lebih baik
                </p>
            </div>
        </label>

        {{-- Cost --}}
        <label
            class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
            {{ old('jenis', $kriteria->jenis ?? '') === 'cost'
                ? 'border-red-400 bg-red-50'
                : 'border-slate-200 bg-sand hover:border-slate-300' }}">

            <input type="radio" name="jenis" value="cost"
                {{ old('jenis', $kriteria->jenis ?? '') === 'cost' ? 'checked' : '' }} class="accent-red-500"
                onchange="updateJenisStyle(this)">

            <div>
                <p class="text-sm font-semibold text-slate-800">Cost</p>
                <p class="text-xs text-slate-400">
                    Nilai lebih kecil = lebih baik
                </p>
            </div>
        </label>

    </div>

    @error('jenis')
        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
    @enderror
</div>

{{-- Bobot --}}
<div class="mb-5">
    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
        Bobot <span class="text-red-400">*</span>
    </label>

    <div class="relative">
        <input type="number" name="bobot" min="0" max="1" step="0.01"
            value="{{ old('bobot', $kriteria->bobot ?? '') }}" placeholder="cth: 0.25"
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
                   text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
                   transition-all @error('bobot') border-red-400 @enderror"
            required>
    </div>

    @error('bobot')
        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
    @enderror

    <p class="text-xs text-slate-400 mt-1">
        Gunakan nilai antara 0 sampai 1.
        Contoh: 0.25 = 25%
    </p>

    @if (isset($sisaBobot))
        <p class="text-xs text-slate-400 mt-1">
            <i class="fas fa-info-circle mr-1"></i>
            Sisa bobot tersedia:
            <strong class="text-teal">{{ $sisaBobot }}</strong>
        </p>
    @endif
</div>

{{-- Deskripsi --}}
<div>
    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
        Deskripsi
    </label>

    <textarea name="deskripsi" rows="3" placeholder="Keterangan singkat tentang kriteria ini..."
        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-sand
               text-slate-900 text-sm focus:outline-none focus:border-teal focus:bg-white
               transition-all resize-none">{{ old('deskripsi', $kriteria->deskripsi ?? '') }}</textarea>
</div>

@push('scripts')
    <script>
        /* Update visual radio jenis saat berubah */
        function updateJenisStyle(el) {

            document.querySelectorAll('input[name="jenis"]').forEach(input => {

                const lbl = input.closest('label');

                lbl.classList.remove(
                    'border-teal',
                    'bg-teal-bg',
                    'border-red-400',
                    'bg-red-50'
                );

                lbl.classList.add(
                    'border-slate-200',
                    'bg-sand'
                );
            });

            const lbl = el.closest('label');

            lbl.classList.remove(
                'border-slate-200',
                'bg-sand'
            );

            if (el.value === 'benefit') {

                lbl.classList.add(
                    'border-teal',
                    'bg-teal-bg'
                );

            } else {

                lbl.classList.add(
                    'border-red-400',
                    'bg-red-50'
                );
            }
        }
    </script>
@endpush
