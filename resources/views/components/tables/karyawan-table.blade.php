{{--
================================================================
components/tables/karyawan-table.blade.php
Komponen tabel daftar karyawan reusable.
================================================================
--}}

<div class="overflow-x-auto">
    <table class="w-full text-sm">

        {{-- ===== HEADER TABEL ===== --}}
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-5 py-3.5">
                    No
                </th>

                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                    Nama Karyawan
                </th>

                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden sm:table-cell">
                    Posisi
                </th>

                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                    Tgl Masuk
                </th>

                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                    Status
                </th>

                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 no-print">
                    Aksi
                </th>
            </tr>
        </thead>

        {{-- ===== BODY TABEL ===== --}}
        <tbody>

            @forelse($karyawans as $i => $k)
                <tr class="border-b border-slate-50 last:border-0 tbl-row">

                    {{-- Nomor --}}
                    <td class="px-5 py-3.5 text-slate-400 text-xs">
                        {{ method_exists($karyawans, 'firstItem') ? $karyawans->firstItem() + $i : $i + 1 }}
                    </td>

                    {{-- Nama Karyawan --}}
                    <td class="px-3 py-3.5">
                        <div class="flex items-center gap-3">

                            <span
                                class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0
                                     text-white text-xs font-bold font-heading
                                     bg-gradient-to-br {{ $k->warna ?? 'from-slate-400 to-slate-600' }}">

                                {{ strtoupper(substr($k->nama_karyawan, 0, 2)) }}
                            </span>

                            <div>
                                <p class="font-semibold text-slate-800">
                                    {{ $k->nama_karyawan }}
                                </p>
                            </div>

                        </div>
                    </td>

                    {{-- Jabatan --}}
                    <td class="px-3 py-3.5 text-slate-600 hidden sm:table-cell">
                        {{ $k->jabatan ?? '—' }}
                    </td>

                    {{-- Tanggal Masuk --}}
                    <td class="px-3 py-3.5 text-slate-500 text-xs hidden md:table-cell">
                        {{ $k->tanggal_masuk ? \Carbon\Carbon::parse($k->tanggal_masuk)->translatedFormat('M Y') : '—' }}
                    </td>

                    {{-- Status --}}
                    <td class="px-3 py-3.5">
                        @include('components.badges.status', [
                            'status' => $k->status,
                        ])
                    </td>

                    {{-- Aksi (SELALU TAMPIL) --}}
                    <td class="px-3 py-3.5 no-print">
                        <div class="flex items-center gap-1.5">

                            <a href="{{ route('karyawan.show', $k->id) }}"
                                class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 hover:bg-slate-100
                                      flex items-center justify-center transition-colors"
                                title="Detail">
                                <i class="fas fa-eye text-xs"></i>
                            </a>

                            <a href="{{ route('karyawan.edit', $k->id) }}"
                                class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100
                                      flex items-center justify-center transition-colors"
                                title="Edit">
                                <i class="fas fa-pen text-xs"></i>
                            </a>

                            <button
                                onclick="openDeleteModal('{{ route('karyawan.destroy', $k->id) }}', '{{ addslashes($k->nama_karyawan) }}')"
                                class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100
                                       flex items-center justify-center transition-colors"
                                title="Hapus">
                                <i class="fas fa-trash text-xs"></i>
                            </button>

                        </div>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="6" class="py-20 text-center">

                        <i class="fas fa-users text-5xl text-slate-200 mb-4 block"></i>

                        <p class="text-slate-500 font-medium">
                            Belum ada data karyawan
                        </p>

                        <p class="text-slate-400 text-sm mt-1">
                            Tambahkan karyawan untuk memulai penilaian
                        </p>

                        <a href="{{ route('karyawan.create') }}"
                            class="inline-flex items-center gap-2 mt-4 text-teal text-sm font-medium hover:underline">

                            <i class="fas fa-plus text-xs"></i>
                            Tambah karyawan pertama
                        </a>

                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>

{{-- ===== PAGINATION ===== --}}
@if (method_exists($karyawans, 'hasPages') && $karyawans->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 no-print">
        {{ $karyawans->appends(request()->query())->links() }}
    </div>
@endif
