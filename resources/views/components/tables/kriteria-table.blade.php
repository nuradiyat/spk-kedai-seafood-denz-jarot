{{--
================================================================
FILE    : components/tables/kriteria-table.blade.php
FUNGSI  : Tabel daftar kriteria dan bobot SAW.
PAKAI   : @include('components.tables.kriteria-table', ['rows' => [...]])
================================================================
--}}
@php
    $rows = $rows ?? [
        ['kode' => 'C1', 'nama' => 'Kehadiran', 'tipe' => 'benefit', 'bobot' => 15, 'bar' => 'bg-blue-400'],
        ['kode' => 'C2', 'nama' => 'Produktivitas Kerja', 'tipe' => 'benefit', 'bobot' => 30, 'bar' => 'bg-teal'],
        ['kode' => 'C3', 'nama' => 'Kedisiplinan', 'tipe' => 'benefit', 'bobot' => 10, 'bar' => 'bg-amber-400'],
        ['kode' => 'C4', 'nama' => 'Pelayanan Pelanggan', 'tipe' => 'benefit', 'bobot' => 20, 'bar' => 'bg-coral'],
        ['kode' => 'C5', 'nama' => 'Pencapaian Target', 'tipe' => 'benefit', 'bobot' => 25, 'bar' => 'bg-purple-400'],
    ];
@endphp

<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-5 py-3.5">Kode
                </th>
                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">Nama
                    Kriteria</th>
                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">Tipe
                </th>
                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">Bobot
                </th>
                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 min-w-[140px] hidden md:table-cell">
                    Visual</th>
                @if (empty($hideAction))
                    <th
                        class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 no-print">
                        Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $k)
                <tr class="border-b border-slate-50 last:border-0 tbl-row">

                    <td class="px-5 py-4">
                        <span class="font-heading font-bold text-ocean text-xs bg-slate-100 px-2.5 py-1 rounded-lg">
                            {{ $k['kode'] }}
                        </span>
                    </td>

                    <td class="px-3 py-4 font-semibold text-slate-800">{{ $k['nama'] }}</td>

                    <td class="px-3 py-4">
                        @include('components.badges.status', ['status' => $k['tipe']])
                    </td>

                    <td class="px-3 py-4">
                        <span class="font-bold text-ocean">{{ $k['bobot'] }}%</span>
                    </td>

                    <td class="px-3 py-4 hidden md:table-cell">
                        <div class="flex items-center gap-2.5">
                            <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bar {{ $k['bar'] }}"
                                    style="width:{{ $k['bobot'] }}%"></div>
                            </div>
                            <span class="text-xs text-slate-400 min-w-[36px]">{{ $k['bobot'] }}%</span>
                        </div>
                    </td>

                    @if (empty($hideAction))
                        <td class="px-3 py-4 no-print">
                            <div class="flex items-center gap-1.5">
                                <a href="#"
                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <button onclick="openDeleteModal('#','{{ $k['nama'] }}')"
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    @endif

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
