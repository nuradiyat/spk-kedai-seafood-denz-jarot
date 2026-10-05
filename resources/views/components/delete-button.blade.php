@props(['action', 'name' => 'data ini'])
{{--
    Tombol hapus dengan konfirmasi TANPA JavaScript (memakai <details> bawaan HTML).
    <x-delete-button :action="url('karyawan/'.$k->id)" :name="$k->nama" />
--}}
<details class="group/del relative">
    <summary class="group/btn relative inline-grid h-9 w-9 cursor-pointer list-none place-items-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600 group-open/del:border-rose-200 group-open/del:bg-rose-50 group-open/del:text-rose-600">
        <x-icon name="trash" class="h-4 w-4" />
        <span class="tooltip group-hover/btn:translate-y-0 group-hover/btn:opacity-100 group-open/del:hidden">Hapus</span>
    </summary>
    <form action="{{ $action }}" method="POST" class="absolute right-full top-1/2 z-20 mr-2 flex -translate-y-1/2 items-center gap-2 whitespace-nowrap rounded-xl bg-white py-1.5 pl-3 pr-1.5 text-xs shadow-lg shadow-slate-900/10 ring-1 ring-slate-200">
        @csrf
        @method('DELETE')
        <span class="text-slate-600">Hapus <b class="font-semibold text-slate-900">{{ $name }}</b>?</span>
        <button type="submit" class="rounded-lg bg-rose-600 px-2.5 py-1.5 font-semibold text-white transition hover:bg-rose-700">Ya, hapus</button>
    </form>
</details>
