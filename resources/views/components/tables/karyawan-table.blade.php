{{--
================================================================
FILE    : components/tables/karyawan-table.blade.php
FUNGSI  : Tabel daftar karyawan reusable.
PAKAI   : @include('components.tables.karyawan-table', ['rows' => [...]])
================================================================
--}}
@php
    /* Dummy data statis - diganti dengan $rows dari controller */
    $rows = $rows ?? [
        [
            'no' => 1,
            'nama' => 'Siti Laras',
            'inisial' => 'SL',
            'warna' => 'from-yellow-400 to-yellow-600',
            'nik' => 'KRY-001',
            'posisi' => 'Kasir',
            'tgl_masuk' => 'Jan 2021',
            'status' => 'aktif',
        ],
        [
            'no' => 2,
            'nama' => 'Ahmad Wibowo',
            'inisial' => 'AW',
            'warna' => 'from-slate-400 to-slate-600',
            'nik' => 'KRY-002',
            'posisi' => 'Pengolah',
            'tgl_masuk' => 'Mar 2021',
            'status' => 'aktif',
        ],
        [
            'no' => 3,
            'nama' => 'Dian Pratiwi',
            'inisial' => 'DP',
            'warna' => 'from-orange-300 to-orange-500',
            'nik' => 'KRY-003',
            'posisi' => 'Pelayan',
            'tgl_masuk' => 'Jun 2021',
            'status' => 'aktif',
        ],
        [
            'no' => 4,
            'nama' => 'Rizal Hidayat',
            'inisial' => 'RH',
            'warna' => 'from-blue-400 to-blue-600',
            'nik' => 'KRY-004',
            'posisi' => 'Pengolah',
            'tgl_masuk' => 'Ags 2022',
            'status' => 'aktif',
        ],
        [
            'no' => 5,
            'nama' => 'Fitri Susanti',
            'inisial' => 'FS',
            'warna' => 'from-purple-400 to-purple-600',
            'nik' => 'KRY-005',
            'posisi' => 'Kasir',
            'tgl_masuk' => 'Jan 2023',
            'status' => 'aktif',
        ],
        [
            'no' => 6,
            'nama' => 'Bagas Santoso',
            'inisial' => 'BS',
            'warna' => 'from-teal-300 to-teal-600',
            'nik' => 'KRY-006',
            'posisi' => 'Pengiriman',
            'tgl_masuk' => 'Apr 2025',
            'status' => 'percobaan',
        ],
    ];
@endphp

<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-5 py-3.5">No
                </th>
                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">Nama
                    Karyawan</th>
                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden sm:table-cell">
                    Posisi</th>
                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                    Tgl Masuk</th>
                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">Status
                </th>
                @if (empty($hideAction))
                    <th
                        class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 no-print">
                        Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $k)
                <tr class="border-b border-slate-50 last:border-0 tbl-row">

                    <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $k['no'] }}</td>

                    <td class="px-3 py-3.5">
                        <div class="flex items-center gap-3">
                            <span
                                class="w-9 h-9 rounded-xl flex items-center justify-center
                                     text-white text-xs font-bold font-heading shrink-0
                                     bg-gradient-to-br {{ $k['warna'] }}">
                                {{ $k['inisial'] }}
                            </span>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $k['nama'] }}</p>
                                <p class="text-[11px] text-slate-400">{{ $k['nik'] }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-3 py-3.5 text-slate-600 hidden sm:table-cell">{{ $k['posisi'] }}</td>
                    <td class="px-3 py-3.5 text-slate-500 text-xs hidden md:table-cell">{{ $k['tgl_masuk'] }}</td>

                    <td class="px-3 py-3.5">
                        @include('components.badges.status', ['status' => $k['status']])
                    </td>

                    @if (empty($hideAction))
                        <td class="px-3 py-3.5 no-print">
                            <div class="flex items-center gap-1.5">
                                <a href="#"
                                    class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 hover:bg-slate-100 flex items-center justify-center transition-colors"
                                    title="Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="#"
                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors"
                                    title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <button onclick="openDeleteModal('#','{{ $k['nama'] }}')"
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition-colors"
                                    title="Hapus">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    @endif

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-16 text-center">
                        <i class="fas fa-users text-5xl text-slate-200 mb-3 block"></i>
                        <p class="text-slate-400 text-sm">Belum ada data karyawan</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>