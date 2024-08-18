<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji Bulanan</title>
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
        <h2>Slip Gaji Bulanan</h2>
        <table>
            <tr>
                <th>ID Gaji Bulanan</th>
                <td>{{ $gajiBulanan->id_gaji_bulanan }}</td>
            </tr>
            <tr>
                <th>Nama Karyawan</th>
                <td>{{ $gajiBulanan->karyawan->nama_karyawan }}</td>
            </tr>
            <tr>
                <th>Bulan</th>
                <td>{{ \Carbon\Carbon::parse($gajiBulanan->bulan)->format('F Y') }}</td>
            </tr>
            <tr>
                <th>Gaji Pokok</th>
                <td>Rp {{ number_format($gajiBulanan->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Uang Transport</th>
                <td>Rp {{ number_format($gajiBulanan->uang_transport, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Uang Makan</th>
                <td>Rp {{ number_format($gajiBulanan->uang_makan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Bonus</th>
                <td>Rp {{ number_format($gajiBulanan->bonus, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>THR</th>
                <td>Rp {{ number_format($gajiBulanan->thr, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Lembur</th>
                <td>Rp {{ number_format($gajiBulanan->total_lembur, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Bonus Lembur</th>
                <td>Rp {{ number_format($gajiBulanan->bonus_lembur, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Denda</th>
                <td>Rp {{ number_format($gajiBulanan->denda, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <th>Total Gaji</th>
                <td>Rp {{ number_format($gajiBulanan->total_gaji, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="download-pdf">
            <form action="{{ route('gaji_bulanan.slip_gaji', $gajiBulanan->id_gaji_bulanan) }}" method="GET" id="download-form">
                <button type="submit">Unduh PDF</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('download-form').addEventListener('submit', function() {
            setTimeout(function() {
                window.location.href = '{{ route('gaji_bulanan.index') }}';
            }, 500); // Redirect after download
        });
    </script>
</body>
</html>
