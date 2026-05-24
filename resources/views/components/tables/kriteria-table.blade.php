{{-- 
================================================================
components/tables/kriteria-table.blade.php
Komponen tabel daftar kriteria reusable.

CARA PAKAI:
    @include('components.tables.kriteria-table')
================================================================
--}}

<div class="overflow-x-auto">
    <table class="w-full text-sm">

        {{-- ===== HEADER ===== --}}
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>

                {{-- Kode --}}
                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-5 py-3.5">
                    Kode
                </th>

                {{-- Nama Kriteria --}}
                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                    Nama Kriteria
                </th>

                {{-- Tipe --}}
                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden sm:table-cell">
                    Tipe
                </th>

                {{-- Bobot --}}
                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                    Bobot
                </th>

                {{-- Visual --}}
                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden lg:table-cell">
                    Visual
                </th>

                {{-- Aksi --}}
                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 no-print">
                    Aksi
                </th>

            </tr>
        </thead>

        {{-- ===== BODY ===== --}}
        <tbody>

            @php
                $barColors = ['bg-blue-400', 'bg-teal', 'bg-amber-400', 'bg-coral', 'bg-purple-400'];
            @endphp

            @forelse($kriterias as $idx => $k)
                <tr class="border-b border-slate-50 last:border-0 tbl-row">

                    {{-- Kode --}}
                    <td class="px-5 py-4">
                        <span class="font-heading font-bold text-ocean text-xs bg-slate-100 px-2.5 py-1 rounded-lg">
                            {{ $k->kode }}
                        </span>
                    </td>

                    {{-- Nama Kriteria --}}
                    <td class="px-3 py-4">

                        <p class="font-semibold text-slate-800">
                            {{ $k->nama_kriteria }}
                        </p>

                        @if ($k->deskripsi)
                            <p class="text-[11px] text-slate-400 mt-0.5">
                                {{ $k->deskripsi }}
                            </p>
                        @endif

                    </td>

                    {{-- Tipe --}}
                    <td class="px-3 py-4 hidden sm:table-cell">

                        @include('components.badges.status', [
                            'status' => $k->jenis,
                        ])

                    </td>

                    {{-- Bobot --}}
                    <td class="px-3 py-4 hidden md:table-cell">

                        <span class="font-bold text-ocean text-base">
                            {{ number_format($k->bobot * 100, 0) }}%
                        </span>

                    </td>

                    {{-- Visual Bobot --}}
                    <td class="px-3 py-4 hidden lg:table-cell">

                        <div class="flex items-center gap-2.5">

                            <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">

                                <div class="h-full rounded-full {{ $barColors[$idx % 5] }}"
                                    style="width: {{ $k->bobot * 100 }}%">
                                </div>

                            </div>

                            <span class="text-xs text-slate-400 min-w-[36px]">
                                {{ number_format($k->bobot * 100, 0) }}%
                            </span>

                        </div>

                    </td>

                    {{-- Aksi --}}
                    <td class="px-3 py-4 no-print">
                        <div class="flex items-center gap-1.5">

                            {{-- Edit --}}
                            <a href="{{ route('kriteria.edit', $k->id) }}"
                                class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100
                                       flex items-center justify-center transition-colors"
                                title="Edit">

                                <i class="fas fa-pen text-xs"></i>

                            </a>

                            {{-- Delete --}}
                            <button
                                onclick="openDeleteModal(
                                    '{{ route('kriteria.destroy', $k->id) }}',
                                    '{{ $k->kode }} — {{ addslashes($k->nama_kriteria) }}'
                                )"
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
                    <td colspan="6" class="py-16 text-center">

                        <i class="fas fa-sliders-h text-5xl text-slate-200 mb-3 block"></i>

                        <p class="text-slate-400 text-sm">
                            Belum ada kriteria penilaian
                        </p>

                        <a href="{{ route('kriteria.create') }}"
                            class="text-teal text-sm font-medium mt-2 inline-block hover:underline">

                            + Tambah kriteria

                        </a>

                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>
