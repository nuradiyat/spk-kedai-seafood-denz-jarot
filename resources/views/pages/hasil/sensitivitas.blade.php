@extends('layouts.app')

@section('title', 'Analisis Sensitivitas · ' . $penilaian->periode)

@section('content')
<x-page-header
    :title="'Analisis Sensitivitas & Simulasi Bobot · ' . $penilaian->periode"
    subtitle="Simulasi pengujian ketahanan keputusan dengan mengubah bobot kriteria secara real-time"
    :crumbs="['Metode SAW', 'Hasil SAW', 'Analisis Sensitivitas']">
    <x-slot name="actions">
        <a href="{{ route('hasil.index', ['periode' => $penilaian->id]) }}" class="btn btn-secondary">
            <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke Hasil SAW
        </a>
    </x-slot>
</x-page-header>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
    {{-- ============================ PANEL KIRI: SLIDER PENGATUR BOBOT ============================ --}}
    <div class="flex flex-col gap-5 lg:col-span-5">
        <x-card class="p-5 sm:p-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                        <x-icon name="sliders" class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Pengatur Bobot Kriteria</h2>
                        <p class="text-[11px] text-slate-500">Geser slider untuk menyimulasikan prioritas</p>
                    </div>
                </div>
                <button type="button" id="btnReset" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-slate-900">
                    <x-icon name="history" class="h-3.5 w-3.5 text-slate-400" /> Reset
                </button>
            </div>

            <div class="mt-5 space-y-4">
                @foreach ($kriterias as $c)
                    @php $persenAsli = round((float) $c->bobot * 100); @endphp
                    <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-3.5 transition hover:border-indigo-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="grid h-6 w-9 place-items-center rounded-md bg-indigo-100 text-[11px] font-bold text-indigo-700">
                                    {{ $c->kode }}
                                </span>
                                <span class="text-xs font-semibold text-slate-800">{{ $c->nama_kriteria }}</span>
                            </div>
                            <div class="text-right">
                                <span id="val-{{ $c->id }}" class="font-mono text-sm font-bold text-indigo-600">{{ $persenAsli }}%</span>
                                <span class="text-[10px] text-slate-400 block">(Asli: {{ $persenAsli }}%)</span>
                            </div>
                        </div>

                        <div class="mt-3">
                            <input type="range"
                                   id="slider-{{ $c->id }}"
                                   data-id="{{ $c->id }}"
                                   data-default="{{ $persenAsli }}"
                                   min="0" max="100" step="1"
                                   value="{{ $persenAsli }}"
                                   class="kriteria-slider h-2 w-full cursor-pointer appearance-none rounded-lg bg-slate-200 accent-indigo-600 focus:outline-none">
                        </div>

                        <div class="mt-2 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Bobot Relatif (Normal): <b id="norm-{{ $c->id }}" class="font-mono text-slate-700">0.00</b></span>
                            <span class="capitalize text-slate-400">{{ $c->jenis }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Indikator Total Bobot --}}
            <div class="mt-5 rounded-xl border border-slate-100 bg-slate-50 p-4">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-semibold text-slate-700">Total Bobot Mentah:</span>
                    <span id="totalBobotRaw" class="font-mono font-bold text-slate-900">100%</span>
                </div>
                <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-slate-200">
                    <div id="totalBar" class="h-full bg-indigo-500 transition-all duration-200" style="width: 100%"></div>
                </div>
                <p class="mt-2 text-[11px] text-slate-500">
                    💡 Sistem otomatis menormalisasi bobot secara proporsional (<b class="text-slate-700">Bobot Kriteria &divide; Total Bobot</b>) sehingga total pembobotan SAW selalu terkunci 100%.
                </p>
            </div>
        </x-card>
    </div>

    {{-- ============================ PANEL KANAN: HASIL PERINGKAT REAL-TIME ============================ --}}
    <div class="flex flex-col gap-5 lg:col-span-7">
        {{-- Kartu Juara Simulasi --}}
        <x-card class="overflow-hidden border border-emerald-100 bg-gradient-to-br from-emerald-50/70 via-white to-sky-50/40 p-5 sm:p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/30">
                        <x-icon name="trophy" class="h-6 w-6" />
                    </span>
                    <div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-bold text-emerald-800">
                            Peringkat #1 Skenario Simulasi
                        </span>
                        <h3 id="winnerName" class="mt-1 text-xl font-bold text-slate-900">-</h3>
                        <p class="text-xs text-slate-500">Nilai Preferensi Simulasi: <b id="winnerScore" class="font-mono text-emerald-700">-</b></p>
                    </div>
                </div>
                <div id="winnerComparisonBadge" class="shrink-0">
                    {{-- Dinamis via JS --}}
                </div>
            </div>
        </x-card>

        {{-- Tabel Ranking Real-time --}}
        <x-card class="overflow-hidden">
            <x-card-header
                title="Tabel Peringkat Simulasi"
                subtitle="Dihitung secara instan berdasarkan formula SAW: V = Σ (w' · r)">
                <span class="inline-flex items-center gap-1 rounded-lg bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">
                    <span class="h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></span> Live Simulation
                </span>
            </x-card-header>

            <div class="overflow-x-auto">
                <table class="tbl min-w-[560px]">
                    <thead class="tbl-head">
                        <tr>
                            <th class="tbl-th w-20">Rank</th>
                            <th class="tbl-th">Karyawan</th>
                            <th class="tbl-th">Skor Asli</th>
                            <th class="tbl-th">Skor Baru (V)</th>
                            <th class="tbl-th text-right">Dinamika</th>
                        </tr>
                    </thead>
                    <tbody id="simulasiTableBody" class="tbl-body">
                        {{-- Dimuat via JS --}}
                    </tbody>
                </table>
            </div>
        </x-card>

        {{-- Ringkasan Akademis untuk Jurnal SINTA 4 --}}
        <x-card class="p-5">
            <div class="flex items-start gap-3">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-violet-50 text-violet-600 ring-1 ring-inset ring-violet-100">
                    <x-icon name="sparkles" class="h-4 w-4" />
                </span>
                <div class="text-xs leading-relaxed text-slate-600">
                    <p class="font-bold text-slate-900">Catatan Analisis Sensitivitas untuk Artikel Ilmiah:</p>
                    <p class="mt-1">
                        Fitur ini menguji <b>stabilitas keputusan</b>. Jika kenaikan bobot salah satu kriteria (misal Produktivitas Kerja C2) mengubah posisi Juara 1 dari Imel ke Sari, hal tersebut membuktikan bahwa keputusan seleksi bonus bersifat <i>sensitif</i> terhadap prioritas produktivitas kerja karyawan.
                    </p>
                </div>
            </div>
        </x-card>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const kriterias = @json($kriterias);
        const karyawans = @json($karyawans);
        const normalisasi = @json($normalisasi);
        const rankingAwal = @json($rankingAwal);
        const nilaiAkhirAwal = @json($nilaiAkhirAwal);

        // Petakan rank awal
        const rankAwalMap = {};
        let rIndex = 1;
        for (const kId in rankingAwal) {
            rankAwalMap[kId] = rIndex++;
        }

        const sliders = document.querySelectorAll('.kriteria-slider');
        const btnReset = document.getElementById('btnReset');

        function escapeHtml(str) {
            return String(str || '').replace(/[&<>"']/g, function (m) {
                return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[m];
            });
        }

        function recalculate() {
            // 1. Ambil bobot mentah dari slider
            let rawSum = 0;
            const rawWeights = {};

            sliders.forEach(slider => {
                const cId = slider.dataset.id;
                const val = parseFloat(slider.value) || 0;
                rawWeights[cId] = val;
                rawSum += val;

                document.getElementById('val-' + cId).innerText = val + '%';
            });

            document.getElementById('totalBobotRaw').innerText = Math.round(rawSum) + '%';
            document.getElementById('totalBar').style.width = Math.min(100, Math.max(0, rawSum)) + '%';

            // 2. Normalisasi bobot: w_norm = val / sum
            const normWeights = {};
            kriterias.forEach(c => {
                const normVal = rawSum > 0 ? (rawWeights[c.id] / rawSum) : 0;
                normWeights[c.id] = normVal;
                document.getElementById('norm-' + c.id).innerText = normVal.toFixed(3);
            });

            // 3. Hitung skor simulasi tiap karyawan: V_i = sum(w'_j * r_ij)
            const scores = karyawans.map(k => {
                let v = 0;
                kriterias.forEach(c => {
                    const r = (normalisasi[k.id] && normalisasi[k.id][c.id]) ? parseFloat(normalisasi[k.id][c.id]) : 0;
                    v += normWeights[c.id] * r;
                });

                return {
                    id: k.id,
                    nama: k.nama_karyawan,
                    jabatan: k.jabatan,
                    skorAwal: parseFloat(nilaiAkhirAwal[k.id] || 0),
                    skorBaru: v,
                    rankAwal: rankAwalMap[k.id] || 99
                };
            });

            // 4. Urutkan dari skor tertinggi
            scores.sort((a, b) => b.skorBaru - a.skorBaru);

            // 5. Update UI Juara Simulasi
            if (scores.length > 0) {
                const top = scores[0];
                document.getElementById('winnerName').innerText = top.nama + ' (' + (top.jabatan || 'Karyawan') + ')';
                document.getElementById('winnerScore').innerText = top.skorBaru.toFixed(3);

                const compBadge = document.getElementById('winnerComparisonBadge');
                if (top.rankAwal === 1) {
                    compBadge.innerHTML = '<span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Juara Bertahan</span>';
                } else {
                    compBadge.innerHTML = '<span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20"><span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Juara Baru (Naik dari Rank #' + top.rankAwal + ')</span>';
                }
            }

            // 6. Render Tabel
            const tbody = document.getElementById('simulasiTableBody');
            tbody.innerHTML = '';

            scores.forEach((item, index) => {
                const newRank = index + 1;
                const diff = item.rankAwal - newRank; // positif = naik, negatif = turun

                let dynamicsHtml = '';
                if (diff > 0) {
                    dynamicsHtml = '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">&blacktriangle; +' + diff + ' Posisi</span>';
                } else if (diff < 0) {
                    dynamicsHtml = '<span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2 py-0.5 text-xs font-bold text-rose-700 ring-1 ring-inset ring-rose-600/20">&blacktriangledown; ' + diff + ' Posisi</span>';
                } else {
                    dynamicsHtml = '<span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-500 ring-1 ring-inset ring-slate-500/20">= Tetap</span>';
                }

                const rankClass = newRank === 1 ? 'font-bold text-amber-600' : 'font-semibold text-slate-700';

                const tr = document.createElement('tr');
                tr.className = 'tbl-row ' + (newRank === 1 ? 'bg-amber-50/40 hover:bg-amber-50/70' : '');
                tr.innerHTML = `
                    <td class="tbl-td ${rankClass}">#${newRank}</td>
                    <td class="tbl-td">
                        <p class="font-semibold text-slate-900">${escapeHtml(item.nama)}</p>
                        <p class="text-xs text-slate-400">${escapeHtml(item.jabatan || '-')}</p>
                    </td>
                    <td class="tbl-td font-mono tabular-nums text-slate-400">${item.skorAwal.toFixed(3)}</td>
                    <td class="tbl-td font-mono font-bold tabular-nums text-indigo-600">${item.skorBaru.toFixed(3)}</td>
                    <td class="tbl-td text-right">${dynamicsHtml}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        sliders.forEach(slider => {
            slider.addEventListener('input', recalculate);
        });

        btnReset.addEventListener('click', function () {
            sliders.forEach(slider => {
                slider.value = slider.dataset.default;
            });
            recalculate();
        });

        // Hitung pertama kali saat load
        recalculate();
    });
</script>
@endsection
