{{-- resources/views/components/tables/penilaian-table.blade.php --}}

<div class="overflow-x-auto">

    <table class="w-full text-sm">

        {{-- HEADER --}}
        <thead class="bg-slate-50 border-b border-slate-200">

            <tr>

                <th
                    class="px-6 py-3.5 text-left
                           text-[11px] font-semibold
                           text-slate-400 uppercase">
                    No
                </th>

                <th
                    class="px-4 py-3.5 text-left
                           text-[11px] font-semibold
                           text-slate-400 uppercase">
                    Periode
                </th>

                <th
                    class="hidden sm:table-cell
                           px-4 py-3.5 text-center
                           text-[11px] font-semibold
                           text-slate-400 uppercase">
                    Jumlah Karyawan
                </th>

                <th
                    class="px-4 py-3.5 text-left
                           text-[11px] font-semibold
                           text-slate-400 uppercase">
                    Status SAW
                </th>

                <th
                    class="hidden md:table-cell
                           px-4 py-3.5 text-left
                           text-[11px] font-semibold
                           text-slate-400 uppercase">
                    Dibuat Oleh
                </th>

                <th
                    class="hidden md:table-cell
                           px-4 py-3.5 text-left
                           text-[11px] font-semibold
                           text-slate-400 uppercase">
                    Tanggal
                </th>

                <th
                    class="px-4 py-3.5 text-center
                           text-[11px] font-semibold
                           text-slate-400 uppercase">
                    Aksi
                </th>

            </tr>

        </thead>

        {{-- BODY --}}
        <tbody>

            @forelse ($penilaians as $index => $penilaian)
                <tr
                    class="border-b border-slate-50
                           hover:bg-slate-50/50
                           transition duration-200
                           last:border-0">

                    {{-- NO --}}
                    <td class="px-6 py-4 text-xs text-slate-400">

                        {{ $penilaians->firstItem() + $index }}

                    </td>

                    {{-- PERIODE --}}
                    <td class="px-4 py-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="w-9 h-9 rounded-xl
                                       bg-gradient-to-br
                                       from-ocean to-ocean-lt
                                       flex items-center justify-center">

                                <i class="fas fa-calendar-alt text-white text-xs"></i>

                            </div>

                            <div>

                                <p class="font-heading font-bold text-ocean text-sm">

                                    {{ $penilaian->periode_label }}

                                </p>

                            </div>

                        </div>

                    </td>

                    {{-- JUMLAH KARYAWAN --}}
                    <td class="hidden sm:table-cell px-4 py-4 text-center">

                        <span
                            class="inline-flex items-center justify-center
                                   w-9 h-9 rounded-xl
                                   bg-ocean/10 text-ocean
                                   font-bold text-sm">
                            {{-- tolong ambil penilaian buka relasi detailPenilaians yng ada di model penilaian
                            ambil karyawan_id dan hitung yang unik(numerik)
                            hitung total karyawan yang dinilai  --}}
                            {{ $penilaian->detailPenilaians->pluck('karyawan_id')->unique()->count() }}

                        </span>

                    </td>

                    {{-- STATUS --}}
                    <td class="px-4 py-4">

                        @if ($penilaian->status_perhitungan === 'sudah_diproses')
                            <span
                                class="inline-flex items-center gap-1.5
                                       bg-teal-50 text-teal-700
                                       border border-teal-200
                                       px-3 py-1 rounded-full
                                       text-xs font-semibold">

                                <i class="fas fa-check-circle text-[10px]"></i>

                                Sudah Diproses

                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5
                                       bg-amber-50 text-amber-700
                                       border border-amber-200
                                       px-3 py-1 rounded-full
                                       text-xs font-semibold">

                                <i class="fas fa-clock text-[10px]"></i>

                                Belum Diproses

                            </span>
                        @endif

                    </td>

                    {{-- USER --}}
                    <td class="hidden md:table-cell
                               px-4 py-4 text-xs text-slate-500">

                        {{ $penilaian->user?->name ?? '-' }}

                    </td>

                    {{-- TANGGAL --}}
                    <td class="hidden md:table-cell px-4 py-4">

                        <p class="text-slate-500 text-xs">

                            {{ $penilaian->tanggal_penilaian }}

                        </p>

                        <p class="text-slate-400 text-[10px] mt-1">
                            {{-- Fungsi diffForHumans() untuk mengubah waktu menjadi format yang lebih ramah
                            defult sebelumnya itu created_at adalah 2026-05-28 16:54:33
                            sesudah pakai diffForHumans() jadi 13 minutes ago  --}}
                            {{ $penilaian->created_at->diffForHumans() }}

                        </p>

                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-4">

                        <div class="flex items-center justify-center gap-1.5">

                            {{-- DETAIL --}}
                            <a href="{{ route('penilaian.show', $penilaian->id) }}"
                                class="w-8 h-8 rounded-lg
                                       bg-slate-50 text-slate-500
                                       hover:bg-slate-100
                                       transition duration-200
                                       flex items-center justify-center">

                                <i class="fas fa-eye text-xs"></i>

                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('penilaian.edit', $penilaian->id) }}"
                                class="w-8 h-8 rounded-lg
                                       bg-blue-50 text-blue-600
                                       hover:bg-blue-100
                                       transition duration-200
                                       flex items-center justify-center">

                                <i class="fas fa-pen text-xs"></i>

                            </a>

                            {{-- HASIL --}}
                            @if ($penilaian->can_show_result)
                                <a href="{{ route('hasil.show', $penilaian->id) }}"
                                    class="w-8 h-8 rounded-lg
                                           bg-teal-50 text-teal-700
                                           hover:bg-teal-100
                                           transition duration-200
                                           flex items-center justify-center">

                                    <i class="fas fa-trophy text-xs"></i>

                                </a>
                            @endif

                            {{-- DELETE --}}
                            <button type="button"
                                onclick="openDeleteModal(
                                    '{{ route('penilaian.destroy', $penilaian->id) }}',
                                    'Periode {{ $penilaian->periode_label }}'
                                )"
                                class="w-8 h-8 rounded-lg
                                       bg-red-50 text-red-500
                                       hover:bg-red-100
                                       transition duration-200
                                       flex items-center justify-center">

                                <i class="fas fa-trash text-xs"></i>

                            </button>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="py-20 text-center">

                        <div class="flex flex-col items-center gap-4">

                            <div
                                class="w-20 h-20 rounded-2xl
                                       bg-slate-50 border border-slate-200
                                       flex items-center justify-center">

                                <i class="fas fa-clipboard-list text-3xl text-slate-300"></i>

                            </div>

                            <div>

                                <p class="text-slate-500 font-semibold text-base">
                                    Belum ada data penilaian
                                </p>

                                <p class="text-slate-400 text-sm mt-1">
                                    Silakan tambahkan penilaian terlebih dahulu
                                </p>

                            </div>

                        </div>

                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>

</div>

{{-- PAGINATION --}}
@if ($penilaians->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">

        {{ $penilaians->links() }}

    </div>
@endif
