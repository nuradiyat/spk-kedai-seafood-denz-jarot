<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Hasil SAW</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #333;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #111;
            padding-bottom: 15px;
        }
        .kop-surat h1 {
            font-size: 24px;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
            color: #000;
            letter-spacing: 1px;
        }
        .kop-surat p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #444;
        }
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 25px;
            text-transform: uppercase;
            color: #000;
        }
        .meta-info {
            width: 100%;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .meta-info td {
            padding: 4px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #94a3b8;
            padding: 10px 8px;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 12px;
        }
        table.data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-center { text-align: center; }
        .badge-diterima {
            color: #166534;
            font-weight: bold;
        }
        .badge-tidak {
            color: #991b1b;
            font-weight: bold;
        }
        .signature {
            width: 100%;
            margin-top: 50px;
        }
        .signature td {
            width: 40%;
            text-align: center;
        }
        .signature-space {
            height: 90px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <h1>UMKM Seafood Denz Jarot</h1>
        <p>Sistem Pendukung Keputusan (SPK) Pemberian Bonus Karyawan</p>
    </div>

    <!-- JUDUL DOKUMEN -->
    <div class="title">
        Laporan Hasil Penilaian Karyawan (Metode SAW)
    </div>

    <!-- INFO META DOKUMEN -->
    <table class="meta-info">
        <tr>
            <td width="15%"><strong>Periode</strong></td>
            <td width="2%">:</td>
            <td width="33%">{{ $penilaian->periode }}</td>
            <td width="18%"><strong>Dicetak Oleh</strong></td>
            <td width="2%">:</td>
            <td width="30%">{{ $penilaian->user->name }}</td>
        </tr>
        <tr>
            <td><strong>Tgl Penilaian</strong></td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->translatedFormat('d F Y') }}</td>
            <td><strong>Waktu Cetak</strong></td>
            <td>:</td>
            <td>{{ now()->translatedFormat('d F Y H:i') }}</td>
        </tr>
    </table>

    <!-- TABEL UTAMA -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="12%">Ranking</th>
                <th width="40%">Nama Karyawan</th>
                <th width="24%">Nilai Akhir (V)</th>
                <th width="24%">Status Bonus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penilaian->hasilSaws->sortBy('ranking') as $hasil)
            <tr>
                <td class="text-center"><strong>{{ $hasil->ranking }}</strong></td>
                <td>{{ $hasil->karyawan->nama_karyawan }}</td>
                <td class="text-center">{{ number_format($hasil->nilai_akhir, 3) }}</td>
                <td class="text-center">
                    @if($hasil->status_bonus == 'Diterima')
                        <span class="badge-diterima">DITERIMA</span>
                    @else
                        <span class="badge-tidak">TIDAK</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <table class="signature">
        <tr>
            <td width="60%"></td>
            <td width="40%">
                <p>Mengetahui,</p>
                <p><strong>Pimpinan UMKM Seafood Denz Jarot</strong></p>
                <div class="signature-space"></div>
                <p><u>( ......................................... )</u></p>
            </td>
        </tr>
    </table>

</body>
</html>