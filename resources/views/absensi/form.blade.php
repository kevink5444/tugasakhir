<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Absensi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/qrcode"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }
        h1 {
            color: #333;
        }
        #qrcode {
            margin: 20px auto;
        }
        button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            color: #fff;
        }
        button:focus {
            outline: none;
        }
        .check-in {
            background-color: #28a745;
        }
        .check-out {
            background-color: #dc3545;
        }
        .notification {
            display: none;
            padding: 10px;
            margin: 10px auto;
            width: 80%;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Absensi dengan QR Code</h1>
    <div id="qrcode"></div>
    <br>
    <button class="check-in" onclick="absenMasuk()">Check-in</button>
    <button class="check-out" onclick="absenKeluar()">Check-out</button>
    <div id="notification" class="notification"></div>

    <script>
        function absenMasuk() {
            fetch("{{ route('absen-masuk') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal melakukan absen masuk');
                }
                return response.json();
            })
            .then(data => {
                showNotification(data.message, true);
                location.reload(); // Reload halaman untuk menampilkan data terbaru
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Gagal melakukan absen masuk', false);
            });
        }

        function absenKeluar() {
            fetch("{{ route('absen-keluar') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringif
