<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
</head>
<body>
    <h1>Absensi dengan QR Code</h1>
    <div id="qrcode"></div>

    <script src="https://cdn.jsdelivr.net/npm/qrcode"></script>
    <script>
        var qrCodeDiv = document.getElementById("qrcode");

        function generateQRCode(text) {
            qrCodeDiv.innerHTML = "";
            new QRCode(qrCodeDiv, text);
        }

        generateQRCode("{{ route('absen-masuk', ['id_karyawan' => Auth::id()]) }}");
    </script>
</body>
</html>
