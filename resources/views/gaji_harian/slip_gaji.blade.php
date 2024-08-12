<!DOCTYPE html>
<html>
<head>
    <title>Slip Gaji Harian</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Slip Gaji Harian</h1>
    <p><strong>Karyawan:</strong> {{ $gaji_harian->karyawan->nama }}</p>
    <p><strong>Tanggal:</strong> {{ $gaji_harian->tanggal->format('d-m-Y') }}</p>
    <p><strong>Jenis Pekerjaan:</strong> {{ $gaji_harian->pekerjaan->nama_pekerjaan }}</p>
    <table>
        <tr>
            <th>Jumlah Pekerjaan</th>
            <th>Target Harian</th>
            <th>Capaian Harian</th>
            <th>Gaji Harian</th>
            <th>Bonus Harian</th>
            <th>Denda Harian</th>
        </tr>
        <tr>
            <td>{{ $gaji_harian->jumlah_pekerjaan }}</td>
            <td>{{ $gaji_harian->target_harian }}</td>
            <td>{{ $gaji_harian->capaian_harian }}</td>
            <td>{{ number_format($gaji_harian->gaji_harian, 0, ',', '.') }}</td>
            <td>{{ number_format($gaji_harian->bonus_harian, 0, ',', '.') }}</td>
            <td>{{ number_format($gaji_harian->denda_harian, 0, ',', '.') }}</td>
        </tr>
    </table>
    <p><strong>Total Gaji:</strong> {{ number_format($gaji_harian->gaji_harian + $gaji_harian->bonus_harian - $gaji_harian->denda_harian, 0, ',', '.') }}</p>
</body>
</html>
