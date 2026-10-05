<div class="mb-4">
    <label class="block mb-2 font-medium">
        Kode Kriteria
    </label>

    <input type="text"
           name="kode"
           value="{{ old('kode', $kriteria->kode ?? '') }}"
           class="w-full border rounded-lg px-4 py-2">
</div>

<div class="mb-4">
    <label class="block mb-2 font-medium">
        Nama Kriteria
    </label>

    <input type="text"
           name="nama_kriteria"
           value="{{ old('nama_kriteria', $kriteria->nama_kriteria ?? '') }}"
           class="w-full border rounded-lg px-4 py-2">
</div>

<div class="mb-4">
    <label class="block mb-2 font-medium">
        Bobot
    </label>

    <input type="number"
           step="0.01"
           name="bobot"
           value="{{ old('bobot', $kriteria->bobot ?? '') }}"
           class="w-full border rounded-lg px-4 py-2">
</div>

<div class="mb-6">
    <label class="block mb-2 font-medium">
        Jenis
    </label>

    <select name="jenis"
            class="w-full border rounded-lg px-4 py-2">

        <option value="benefit"
            {{ old('jenis', $kriteria->jenis ?? '') == 'benefit' ? 'selected' : '' }}>
            Benefit
        </option>

        <option value="cost"
            {{ old('jenis', $kriteria->jenis ?? '') == 'cost' ? 'selected' : '' }}>
            Cost
        </option>

    </select>
</div>

<button type="submit"
        class="bg-blue-600 text-white px-5 py-2 rounded-lg">
    Simpan
</button>