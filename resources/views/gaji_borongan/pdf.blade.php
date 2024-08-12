<!-- resources/views/gaji_borongan/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji Borongan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .slip-gaji {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
        .slip-gaji h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .slip-gaji table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .slip-gaji th, .slip-gaji td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .slip-gaji .total {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="slip-gaji">
        <h2>Slip Gaji Borongan</h2>
        <table>
            <tr>
                <th>ID Gaji Borongan</th>
                <td>{{ $gaji->id_gaji_borongan }}</td>
            </tr>
            <tr>
                <th>Nama Karyawan</th>
                <td>{{ $gaji->karyawan->nama_karyawan }}</td>
            </tr>
            <tr>
                <th>Minggu Mulai</th>
                <td>{{ $gaji->minggu_mulai }}</td>
            </tr>
            <tr>
                <th>Minggu Selesai</th>
                <td>{{ $gaji->minggu_selesai }}</td>
            </tr>
            <tr>
                <th>Total Gaji Borongan</th>
                <td>Rp {{ number_format($gaji->total_gaji_borongan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Bonus</th>
                <td>Rp {{ number_format($gaji->total_bonus, 0, ',', '.') }}</td>
            </tr>
            <tr>
       
