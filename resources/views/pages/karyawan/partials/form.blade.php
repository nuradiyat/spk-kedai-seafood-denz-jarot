<div class="mb-4">
    <label class="block mb-2 font-medium">
        Nama Karyawan
    </label>

    <input type="text"
           name="nama_karyawan"
           value="{{ old('nama_karyawan', $karyawan->nama_karyawan ?? '') }}"
           class="w-full border rounded-lg px-4 py-2">
</div>

<div class="mb-4">
    <label class="block mb-2 font-medium">
        Jabatan
    </label>

    <input type="text"
           name="jabatan"
           value="{{ old('jabatan', $karyawan->jabatan ?? '') }}"
           class="w-full border rounded-lg px-4 py-2">
</div>

<div class="mb-4">
    <label class="block mb-2 font-medium">
        Tanggal Masuk
    </label>

    <input type="date"
           name="tanggal_masuk"
           value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk ?? '') }}"
           class="w-full border rounded-lg px-4 py-2">
</div>

<div class="mb-6">
    <label class="block mb-2 font-medium">
        Status
    </label>

    <select name="status"
            class="w-full border rounded-lg px-4 py-2">

        <option value="aktif"
            {{ old('status', $karyawan->status ?? '') == 'aktif' ? 'selected' : '' }}>
            Aktif
        </option>

        <option value="nonaktif"
            {{ old('status', $karyawan->status ?? '') == 'nonaktif' ? 'selected' : '' }}>
            Nonaktif
        </option>

    </select>
</div>

<button type="submit"
        class="bg-blue-600 text-white px-5 py-2 rounded-lg">
    Simpan
</button>