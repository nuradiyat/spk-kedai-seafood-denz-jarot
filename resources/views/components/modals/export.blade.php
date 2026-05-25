{{--
================================================================
FILE    : components/modals/export.blade.php
FUNGSI  : Modal pilihan format export laporan (PDF / Excel).
          Dipanggil via JS: openExportModal()
================================================================
--}}
<div id="exportModal" class="fixed inset-0 bg-ocean/60 backdrop-blur-sm z-[999] hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8">

        {{-- Icon --}}
        <div
            class="w-14 h-14 rounded-2xl bg-teal-bg border border-teal-200
                    flex items-center justify-center mb-5 mx-auto">
            <i class="fas fa-file-export text-teal text-xl"></i>
        </div>

        <h3 class="font-heading font-bold text-ocean text-xl text-center mb-2">Export Laporan</h3>
        <p class="text-slate-400 text-sm text-center mb-6">Pilih format file laporan</p>

        {{-- Opsi format --}}
        <div class="space-y-3 mb-6">

            {{-- PDF --}}
            <a href="#"
                class="flex items-center gap-4 p-4 rounded-xl border-2 border-slate-200
                      hover:border-red-300 hover:bg-red-50 transition-all group">
                <div
                    class="w-10 h-10 rounded-xl bg-red-50 group-hover:bg-red-100
                            flex items-center justify-center shrink-0">
                    <i class="fas fa-file-pdf text-red-500 text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-800 text-sm">Export PDF</p>
                    <p class="text-xs text-slate-400">Siap cetak, format resmi</p>
                </div>
                <i
                    class="fas fa-arrow-right text-slate-300 text-xs ml-auto group-hover:text-red-400 transition-colors"></i>
            </a>

            {{-- Excel --}}
            <a href="#"
                class="flex items-center gap-4 p-4 rounded-xl border-2 border-slate-200
                      hover:border-green-300 hover:bg-green-50 transition-all group">
                <div
                    class="w-10 h-10 rounded-xl bg-green-50 group-hover:bg-green-100
                            flex items-center justify-center shrink-0">
                    <i class="fas fa-file-excel text-green-600 text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-800 text-sm">Export Excel</p>
                    <p class="text-xs text-slate-400">Untuk analisis lanjutan</p>
                </div>
                <i
                    class="fas fa-arrow-right text-slate-300 text-xs ml-auto group-hover:text-green-500 transition-colors"></i>
            </a>

        </div>

        <button onclick="closeExportModal()"
            class="w-full py-2.5 rounded-xl border border-slate-200 text-slate-600
                       text-sm font-medium hover:bg-slate-50 transition-colors">
            Batal
        </button>

    </div>
</div>
