{{--
================================================================
FILE    : components/badges/status.blade.php
FUNGSI  : Badge status serbaguna (karyawan, keputusan, kriteria).
PAKAI   : @include('components.badges.status', ['status' => '...'])
STATUS  : aktif | percobaan | tidak_aktif | bonus | pertimbangan
          | tidak | benefit | cost
================================================================
--}}
@php
    $map = [
        'aktif' => ['cls' => 'bg-teal-50 text-teal-700 border border-teal-200', 'lbl' => 'Aktif'],
        'percobaan' => ['cls' => 'bg-amber-50 text-amber-700 border border-amber-200', 'lbl' => 'Percobaan'],
        'tidak_aktif' => ['cls' => 'bg-slate-100 text-slate-500 border border-slate-200', 'lbl' => 'Tidak Aktif'],
        'bonus' => ['cls' => 'bg-teal-50 text-teal-700 border border-teal-200', 'lbl' => '✓ Penerima Bonus'],
        'pertimbangan' => ['cls' => 'bg-amber-50 text-amber-700 border border-amber-200', 'lbl' => 'Pertimbangan'],
        'tidak' => ['cls' => 'bg-slate-100 text-slate-500 border border-slate-200', 'lbl' => 'Belum Memenuhi'],
        'benefit' => ['cls' => 'bg-teal-50 text-teal-700 border border-teal-200', 'lbl' => 'Benefit'],
        'cost' => ['cls' => 'bg-red-50 text-red-600 border border-red-200', 'lbl' => 'Cost'],
    ];
    $s = $map[$status ?? 'aktif'] ?? [
        'cls' => 'bg-slate-100 text-slate-500 border border-slate-200',
        'lbl' => ucfirst($status ?? ''),
    ];
@endphp
<span
    class="{{ $s['cls'] }} inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap">
    {{ $s['lbl'] }}
</span>
