{{-- 
================================================================
pages/bonus/partials/form.blade.php
Partial reusable field form bonus.
Dipakai oleh: create.blade.php dan edit.blade.php
================================================================
--}}

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

    {{-- Informasi Penilaian --}}
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">

        <div class="flex items-center gap-3">

            <div class="w-8 h-8 rounded-lg bg-ocean/10 flex items-center justify-center">
                <i class="fas fa-info-circle text-ocean text-sm"></i>
            </div>

            <h3 class="font-heading font-bold text-ocean">
                Informasi Penilaian
            </h3>

        </div>

    </div>

    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Periode --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">
                Periode
            </label>

            <input type="text" value="{{ $bonus->periode_label }}" readonly
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50">
        </div>

        {{-- Tanggal Penilaian --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">
                Tanggal Penilaian
            </label>

            <input type="text" value="{{ $bonus->tanggal_penilaian_label }}" readonly
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50">
        </div>

        {{-- Jumlah Karyawan --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">
                Jumlah Karyawan
            </label>

            <input type="text" value="{{ $bonus->jumlah_karyawan }} Karyawan" readonly
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50">
        </div>

        {{-- Status Perhitungan --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">
                Status Perhitungan SAW
            </label>

            <input type="text" value="{{ ucfirst(str_replace('_', ' ', $bonus->status_perhitungan)) }}" readonly
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50">
        </div>

        {{-- Status Bonus --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">
                Status Bonus
            </label>

            <input type="text" value="{{ $bonus->status_bonus }}" readonly
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50">
        </div>

        {{-- Total Bonus Saat Ini --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">
                Total Bonus Saat Ini
            </label>

            <input type="text"
                value="{{ $bonus->total_bonus ? 'Rp ' . number_format($bonus->total_bonus, 0, ',', '.') : 'Belum Diisi' }}"
                readonly class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50">
        </div>

    </div>

</div>

<input type="hidden" name="bonus_id" value="{{ $bonus->id }}">

{{-- inpur bonus --}}
<div class="bg-white rounded-2xl border border-slate-200 p-6 mt-5">

    <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">
        Total Bonus <span class="text-red-500">*</span>
    </label>

    <input type="number" name="total_bonus" min="0" value="{{ old('total_bonus', $bonus->total_bonus) }}"
        placeholder="Masukkan total bonus" required
        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200
               focus:outline-none focus:border-teal">

    @error('total_bonus')
        <p class="text-red-500 text-xs mt-1">
            {{ $message }}
        </p>
    @enderror

</div>
