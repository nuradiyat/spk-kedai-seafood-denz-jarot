{{--
================================================================
FILE    : components/tables/hasil-table.blade.php
FUNGSI  : Tabel hasil ranking SAW lengkap dengan perhitungan.
PAKAI   : @include('components.tables.hasil-table', ['rows' => [...]])
================================================================
--}}
@php
    $kriterias = $kriterias ?? [
        ['kode' => 'C1', 'bobot' => 0.15],
        ['kode' => 'C2', 'bobot' => 0.3],
        ['kode' => 'C3', 'bobot' => 0.1],
        ['kode' => 'C4', 'bobot' => 0.2],
        ['kode' => 'C5', 'bobot' => 0.25],
    ];
    $rows = $rows ?? [
        [
            'rank' => 1,
            'nama' => 'Siti Laras',
            'inisial' => 'SL',
            'warna' => 'from-yellow-400 to-yellow-600',
            'wr' => [0.15, 0.3, 0.08, 0.2, 0.25],
            'vi' => 0.98,
            'status' => 'bonus',
        ],
        [
            'rank' => 2,
            'nama' => 'Ahmad Wibowo',
            'inisial' => 'AW',
            'warna' => 'from-slate-400 to-slate-600',
            'wr' => [0.12, 0.3, 0.1, 0.16, 0.25],
            'vi' => 0.93,
            'status' => 'bonus',
        ],
        [
            'rank' => 3,
            'nama' => 'Dian Pratiwi',
            'inisial' => 'DP',
            'warna' => 'from-orange-300 to-orange-500',
            'wr' => [0.15, 0.24, 0.08, 0.2, 0.1875],
            'vi' => 0.8575,
            'status' => 'bonus',
        ],
        [
            'rank' => 4,
            'nama' => 'Rizal Hidayat',
            'inisial' => 'RH',
            'warna' => 'from-blue-400 to-blue-600',
            'wr' => [0.12, 0.24, 0.08, 0.16, 0.25],
            'vi' => 0.85,
            'status' => 'bonus',
        ],
        [
            'rank' => 5,
            'nama' => 'Fitri Susanti',
            'inisial' => 'FS',
            'warna' => 'from-purple-400 to-purple-600',
            'wr' => [0.09, 0.24, 0.08, 0.16, 0.1875],
            'vi' => 0.7575,
            'status' => 'pertimbangan',
        ],
        [
            'rank' => 6,
            'nama' => 'Bagas Santoso',
            'inisial' => 'BS',
            'warna' => 'from-teal-300 to-teal-600',
            'wr' => [0.12, 0.18, 0.06, 0.12, 0.1875],
            'vi' => 0.6675,
            'status' => 'tidak',
        ],
    ];
    $rankBg = [1 => 'bg-yellow-50/40', 2 => 'bg-slate-50/20', 3 => 'bg-orange-50/30'];
@endphp

<div class="overflow-x-auto">
    <table class="w-full text-sm border-collapse" style="min-width:640px">
        <thead>
            <tr>
                <th
                    class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 bg-slate-50 border border-slate-200">
                    Rank</th>
                <th
                    class="text-left   text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-4 py-3.5 bg-slate-50 border border-slate-200 min-w-[140px]">
                    Karyawan</th>
                @foreach ($kriterias as $idx => $k)
                    <th
                        class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 bg-slate-50 border border-slate-200">
                        w<sub>{{ $idx + 1 }}</sub>·r<sub>{{ $idx + 1 }}</sub><br>
                        <span class="font-normal normal-case tracking-normal text-[10px]">{{ $k['kode'] }}</span>
                    </th>
                @endforeach
                <th
                    class="text-center text-[11px] font-bold text-teal-700 uppercase tracking-wide px-4 py-3.5 bg-teal-bg border border-teal-200 min-w-[80px]">
                    V<sub>i</sub></th>
                <th
                    class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-4 py-3.5 bg-slate-50 border border-slate-200">
                    Keputusan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $item)
                <tr class="{{ $rankBg[$item['rank']] ?? '' }}">
                    <td class="px-3 py-3.5 border border-slate-200 text-center">
                        @include('components.badges.ranking', ['rank' => $item['rank']])
                    </td>
                    <td class="px-4 py-3.5 border border-slate-200">
                        <div class="flex items-center gap-2.5">
                            <span
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-[10px] font-bold font-heading shrink-0
                                     bg-gradient-to-br {{ $item['warna'] }}">
                                {{ $item['inisial'] }}
                            </span>
                            <span class="font-semibold text-slate-800 text-sm">{{ $item['nama'] }}</span>
                        </div>
                    </td>
                    @foreach ($item['wr'] as $wr)
                        <td class="px-3 py-3.5 border border-slate-200 text-center text-slate-700 font-medium text-xs">
                            {{ number_format($wr, 4) }}
                        </td>
                    @endforeach
                    <td
                        class="px-4 py-3.5 border border-teal-200 text-center font-heading font-bold text-base bg-teal-bg/60
                            {{ $item['rank'] <= 2 ? 'text-teal-800' : ($item['rank'] <= 4 ? 'text-teal-700' : 'text-slate-500') }}">
                        {{ number_format($item['vi'], 4) }}
                    </td>
                    <td class="px-4 py-3.5 border border-slate-200 text-center">
                        @include('components.badges.status', ['status' => $item['status']])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
