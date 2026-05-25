{{--
================================================================
FILE    : components/modals/delete.blade.php
FUNGSI  : Modal konfirmasi hapus data global.
          Dipanggil via JS: openDeleteModal(url, namaData)
================================================================
--}}
<div id="deleteModal" class="fixed inset-0 bg-ocean/60 backdrop-blur-sm z-[999] hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8">

        {{-- Icon --}}
        <div
            class="w-14 h-14 rounded-2xl bg-red-50 border border-red-100
                    flex items-center justify-center mb-5 mx-auto">
            <i class="fas fa-trash-alt text-red-500 text-xl"></i>
        </div>

        <h3 class="font-heading font-bold text-ocean text-xl text-center mb-2">Hapus Data?</h3>
        <p class="text-slate-400 text-sm text-center mb-6">
            Data <strong id="deleteTargetName" class="text-slate-700"></strong>
            akan dihapus <span class="text-red-500 font-semibold">permanen</span>.
        </p>

        {{-- Tombol --}}
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()"
                class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-600
                           text-sm font-medium hover:bg-slate-50 transition-colors">
                Batal
            </button>
            <form id="deleteForm" action="#" method="POST" class="flex-1">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit"
                    class="w-full py-2.5 rounded-xl bg-red-500 hover:bg-red-600
                               text-white text-sm font-semibold transition-colors">
                    <i class="fas fa-trash text-xs mr-1"></i> Hapus
                </button>
            </form>
        </div>

    </div>
</div>
