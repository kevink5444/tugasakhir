<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji Harian</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            background-color: #f4f4f4;
            color: #333;
        }
        .slip-gaji {
            width: 100%;
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .slip-gaji h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            color: #007BFF;
        }
        .slip-gaji table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .slip-gaji th, .slip-gaji td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .slip-gaji th {
            background-color: #007BFF;
            color: #fff;
            font-weight: bold;
        }
        .slip-gaji td {
            background-color: #f9f9f9;
        }
        .slip-gaji .total {
            text-align: right;
            font-weight: bold;
            background-color: #e9ecef;
        }
        .download-pdf {
            text-align: center;
            margin-top: 30px;
        }
        .download-pdf button {
            padding: 12px 24px;
            font-size: 14px;
            cursor: pointer;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
        }
        .download-pdf button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="slip-gaji">
        <h2>Slip Gaji Harian</h2>
        <table>
            <tr>
                <th>ID Gaji Harian</th>
                <td>{{ $gajiHarian->id_gaji_harian }}</td>
            </tr>
            <tr>
                <th>Nama Karyawan</th>
                <td>{{ $gajiHarian->karyawan->nama_karyawan }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>{{ \Carbon\Carbon::parse($gajiHarian->tanggal)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Jenis Pekerjaan</th>
                <td>{{ $gajiHarian->pekerjaan->nama_pekerjaan }}</td>
            </tr>
            <tr>
                <th>Jumlah Pekerjaan</th>
                <td>{{ $gajiHarian->jumlah_pekerjaan }}</td>
            </tr>
            <tr>
                <th>Target Harian</th>
                <td>{{ $gajiHarian->target_harian }}</td>
            </tr>
            <tr>
                <th>Capaian Harian</th>
                <td>{{ $gajiHarian->capaian_harian }}</td>
            </tr>
            <tr>
                <th>Gaji Harian</th>
                <td>Rp {{ number_format($gajiHarian->gaji_harian, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Bonus Harian</th>
                <td>Rp {{ number_format($gajiHarian->bonus_harian, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Denda Harian</th>
                <td>Rp {{ number_format($gajiHarian->denda_harian, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Status Pengambilan</th>
                <td>{{ $gajiHarian->status_pengambilan ? 'Sudah Diambil' : 'Belum Diambil' }}</td>
            </tr>
        </table>

        <div class="download-pdf">
            <form action="{{ route('gaji_harian.downloadPdf', $gajiHarian->id_gaji_harian) }}" method="GET" id="download-form">
                <button type="submit">Unduh PDF</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('download-form').addEventListener('submit', function() {
            setTimeout(function() {
                window.location.href = '{{ route('gaji_harian.index') }}';
            }, 500); // Redirect after download
        });
    </script>
</body>
</html>
