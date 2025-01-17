<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Lembur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Riwayat Lembur</h2>
    <table>
        <thead>
            <tr>
                <th>ID Lembur</th>
                <th>Tanggal Lembur</th>
                <th>Jam Lembur</th>
                <th>Status</th>
                <th>Bonus Lembur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lemburData as $lembur)
                <tr>
                    <td>{{ $lembur->id_lembur }}</td>
                    <td>{{ $lembur->tanggal_lembur }}</td>
                    <td>{{ $lembur->jam_lembur }}</td>
                    <td>{{ $lembur->status_lembur }}</td>
                    <td>{{ $lembur->bonus_lembur ?? 'Menunggu Persetujuan' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
