<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/qrcode"></script>
</head>
<body>
    <h1>Absensi dengan QR Code</h1>
    <div id="qrcode"></div>
    <br>
    <button onclick="absenMasuk()">Check-in</button>
    <button onclick="absenKeluar()">Check-out</button>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var qrCodeDiv = document.getElementById("qrcode");

            function generateQRCode(text) {
                qrCodeDiv.innerHTML = "";
                new QRCode(qrCodeDiv, text);
            }

            generateQRCode("{{ route('absen-masuk', ['id_karyawan' => Auth::id()]) }}");

            function absenMasuk() {
                fetch("{{ route('absen-masuk', ['id_karyawan' => Auth::id()]) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal melakukan absen masuk');
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal melakukan absen masuk');
                });
            }

            function absenKeluar() {
                fetch("{{ route('absen-keluar', ['id_karyawan' => Auth::id()]) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal melakukan absen keluar');
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal melakukan absen keluar');
                });
            }
            
            window.absenMasuk = absenMasuk;
            window.absenKeluar = absenKeluar;
        });
    </script>
</body>
</html>
