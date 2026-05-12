<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>
        Hasil SAW
    </title>

    <style>

        body{
            font-family: sans-serif;
            font-size: 14px;
        }

        h1{
            text-align: center;
            margin-bottom: 10px;
        }

        .info{
            margin-bottom: 20px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td{
            border: 1px solid #000;
            padding: 8px;
        }

        table th{
            background: #f3f4f6;
        }

    </style>
</head>
<body>

    <h1>
        Hasil Perhitungan SAW
    </h1>

    <div class="info">

        <p>
            <strong>Periode:</strong>
            {{ $penilaian->periode }}
        </p>

        <p>
            <strong>Tanggal:</strong>
            {{ $penilaian->tanggal_penilaian }}
        </p>

        <p>
            <strong>Admin:</strong>
            {{ $penilaian->user->name }}
        </p>

    </div>

    <table>

        <thead>

            <tr>

                <th>Ranking</th>
                <th>Nama Karyawan</th>
                <th>Nilai Akhir</th>
                <th>Status Bonus</th>

            </tr>

        </thead>

        <tbody>

            @foreach($penilaian->hasilSaws->sortBy('ranking') as $hasil)

            <tr>

                <td align="center">
                    {{ $hasil->ranking }}
                </td>

                <td>
                    {{ $hasil->karyawan->nama_karyawan }}
                </td>

                <td align="center">
                    {{ number_format($hasil->nilai_akhir, 3) }}
                </td>

                <td align="center">
                    {{ $hasil->status_bonus }}
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>