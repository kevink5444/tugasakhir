<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Slip Gaji Bulanan</h1>
    <p>Nama Karyawan: {{ $gajiBulanan->karyawan->nama }}</p>
    <p>Bulan: {{ \Carbon\Carbon::parse($gajiBulanan->bulan)->format('F Y') }}</p>

    <table>
        <tr>
            <th>Komponen</th>
            <th>Jumlah</th>
        </tr>
        <tr>
            <td>Gaji Pokok</td>
            <td>{{ number_format($gajiBulanan->gaji_pokok, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Uang Transport</td>
            <td>{{ number_format($gajiBulanan->uang_transport, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Uang Makan</td>
            <td>{{ number_format($gajiBulanan->uang_makan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Gaji</td>
            <td>{{ number_format($gajiBulanan->total_gaji, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p>Status Pengambilan: {{ $gajiBulanan->status_pengambilan ? 'Sudah Diambil' : 'Belum Diambil' }}</p>
</body>
</html>