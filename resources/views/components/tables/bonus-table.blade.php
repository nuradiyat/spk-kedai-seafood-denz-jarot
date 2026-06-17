{{--
================================================================
components/tables/bonus-table.blade.php
Komponen tabel daftar bonus reusable.
================================================================
--}}

<div class="overflow-x-auto">
    <table class="w-full text-sm">

        {{-- ===== HEADER TABEL ===== --}}
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>

                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                    Periode
                </th>

                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden sm:table-cell">
                    Jumlah Karyawan
                </th>

                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                    Status Perhitungan SAW
                </th>
                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 hidden md:table-cell">
                    Status Bonus
                </th>

                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                    Total Bonus
                </th>

                <th class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5">
                    Tanggal Penilaian
                </th>

                <th
                    class="text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wide px-3 py-3.5 no-print">
                    Aksi
                </th>
            </tr>
        </thead>

        {{-- ===== BODY TABEL ===== --}}
        <tbody>

            {{-- Jika ada data kriteria maka tampilkan
            palkai metode @forelse ( as )
                ini menampilkan data
            @empty
                ini tidak ada data 
            @endforelse --}}

            {{-- menampilkan priode, jumlah karyawan, status saw perhitungan saw, status bonus, total bonus, tanggal penilaian, aksi --}}
            @forelse($bonuses as $bonus)
                <tr class="border-b border-slate-50 last:border-0 tbl-row">

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

                                    {{ $bonus->penilaian->periode ?? '-' }}

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

                            {{ $bonus->jumlah_karyawan ?? '-' }}
                        </span>

                    </td>

                    {{-- Status perhitungan Saw, relasi penilaian --}}
                    <td class="px-4 py-4">
                        @php
                            $status = $bonus->status_perhitungan;
                        @endphp

                        @if ($status === 'sudah_diproses')
                            <span
                                class="inline-flex items-center gap-1.5 bg-teal-50 text-teal-700 border border-teal-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-check-circle text-[10px]"></i>
                                Sudah Diproses
                            </span>
                        @elseif ($status === 'hitung_ulang_saw')
                            <span
                                class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-sync-alt text-[10px]"></i>
                                Hitung Ulang Saw
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-clock text-[10px]"></i>
                                Belum Diproses Sayang
                            </span>
                        @endif
                    </td>


                    {{-- Status bonus di ambil dari bonus --}}
                    <td class="px-3 py-3.5">
                        @php
                            $status = $bonus->status_bonus;
                        @endphp

                        @if ($status === 'sudah_di_berikan')
                            <span
                                class="inline-flex items-center gap-1.5 bg-teal-50 text-teal-700 border border-teal-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-check-circle text-[10px]"></i>
                                Sudah Diberikan
                            </span>
                        @elseif ($status === 'belum_di_berikan')
                            <span
                                class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-clock text-[10px]"></i>
                                Belum Diberikan
                            </span>
                        @endif
                    </td>

                    {{-- Total bonus --}}
                    <td class="px-3 py-3.5 font-medium text-teal">
                        {{ $bonus->total_bonus ? 'Rp ' . number_format($bonus->total_bonus, 0, ',', '.') : 'Rp 0' }}
                    </td>

                    {{-- Tanggal penilaian, relasi penilaian --}}
                    <td class="hidden md:table-cell px-4 py-4">

                        <p class="text-slate-500 text-xs">

                            {{-- Tanggal penilaian di ambil dari $bonuses->through controller --}}
                            {{ $bonus->tanggal_dipenilaian }}

                            {{-- ini langsung ambil di model bonus dengan $bonus->penilaian->tanggal_penilaian 
                            karena kita sudah mengambil data penilaian dengan with('penilaian') jadi kita bisa langsung mengambil data penilaian yang terkait dengan bonus lalu ambil tanggal penilaian dengan ->tanggal_penilaian, kalau tidak ada data penilaian maka tampilkan '-' --}}
                            {{-- {{ $bonus->penilaian->tanggal_penilaian ?? '-' }} --}}

                        </p>

                        <p class="text-slate-400 text-[10px] mt-1">


                            {{-- waktu penilaian di ambil dari $bonuses->through controller --}}
                            {{ $bonus->waktu_penilaian ?? '-' }} {{-- ini sudah di set di controller dengan diffForHumans jadi tampilannya seperti "2 hari yang lalu", "3 jam yang lalu", dll --}}

                            {{-- ini langsung ambil di model bonus dengan $bonus->penilaian->created_at 
                            karena kita sudah mengambil data penilaian dengan with('penilaian') jadi kita bisa langsung mengambil data penilaian yang terkait dengan bonus lalu ambil tanggal pembuatan penilaian dengan ->created_at, kalau tidak ada data penilaian maka tampilkan '-' --}}
                            {{-- {{ $bonus->penilaian->created_at ?? '-' }} --}}

                        </p>

                    </td>

                    {{-- Aksi berikan total bonus(tambah), edit
                    berikan total bonus(tambah) di berikan ketika status bonus adalah "belum diberikan"
                    edit berikan ketika status bonus adalah "sudah diberikan" dan merubah status saw menjadi "hitung ulang saw"  --}}
                    <td class="px-3 py-3.5 no-print">
                        <div class="flex items-center gap-1.5">

                            {{-- <a href="{{ route('bonus.show', $bonus->id) }}"
                                class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 hover:bg-slate-100
                                      flex items-center justify-center transition-colors"
                                title="Detail">
                                <i class="fas fa-eye text-xs"></i>
                            </a> --}}

                            {{-- jika total_bonus null maka tampilkan tombol Tambah Bonus
                            namun jika sudah ada total_bonus maka tampilkan tombol Edit Bonus data total bonus di dapat dari 
                            $bonus->total_bonus yang di kirirm dari controller metod edit --}}
                            {{-- @if (is_null($bonus->total_bonus)) --}}
                                {{-- Tambah Bonus --}}
                                <a href="{{ route('bonus.tambah', $bonus->id) }}"
                                    class="w-8 h-8 rounded-lg bg-green-50 text-green-600 hover:bg-green-100
                                            flex items-center justify-center transition-colors"
                                    title="Tambah Bonus">
                                    <i class="fas fa-money-bill-wave text-xs"></i>
                                </a>
                
                        </div>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="6" class="py-20 text-center">

                        <i class="fas fa-users text-5xl text-slate-200 mb-4 block"></i>

                        <p class="text-slate-500 font-medium">
                            Belum ada data bonus
                        </p>

                        <p class="text-slate-400 text-sm mt-1">
                            Tambahkan bonus untuk memulai 
                        </p>

                        <a href="{{ route('karyawan.create') }}"
                            class="inline-flex items-center gap-2 mt-4 text-teal text-sm font-medium hover:underline">

                            <i class="fas fa-plus text-xs"></i>
                            Tambah bonus pertama
                        </a>

                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>

{{-- ===== PAGINATION ===== --}}
<div class="mt-6 px-5 py">
    {{ $bonuses->links() }} {{-- pagination otomatis dari Laravel, pastikan di controller sudah menggunakan paginate() --}}
</div>
