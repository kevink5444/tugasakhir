<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Data Absensi</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td> <!-- Pastikan bahwa $item->nama sudah sesuai dengan field nama yang ada di model -->
                        <td>{{ $item->tanggal }}</td> <!-- Pastikan bahwa $item->tanggal sudah sesuai dengan field tanggal yang ada di model -->
                        <td>{{ $item->waktu_masuk }}</td> <!-- Pastikan bahwa $item->waktu_masuk sudah sesuai dengan field waktu_masuk yang ada di model -->
                        <td>{{ $item->waktu_keluar }}</td> <!-- Pastikan bahwa $item->waktu_keluar sudah sesuai dengan field waktu_keluar yang ada di model -->
                        <td>{{ $item->status }}</td> <!-- Pastikan bahwa $item->status sudah sesuai dengan field status yang ada di model -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data absensi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
