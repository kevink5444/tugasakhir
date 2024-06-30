<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="file"], input[type="hidden"], button, .back-button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #218838;
        }
        .back-button {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .error-messages {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Form Absensi</h1>
        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="absensiForm" action="{{ route('absensi.simpan') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            <input type="hidden" name="email_karyawan" value="{{ $email }}">

            <label for="foto">Foto:</label>
            <input type="file" name="foto" id="foto" required>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <button type="submit">Submit</button>
        </form>
        <a href="#" class="back-button" id="backButton">Kembali</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                }, function(error) {
                    alert('Error getting geolocation: ' + error.message);
                });
            } else {
                alert('Geolocation tidak didukung oleh browser ini.');
            }
        });

        function validateForm() {
            var latitude = document.getElementById('latitude').value;
            var longitude = document.getElementById('longitude').value;
            if (latitude === '' || longitude === '') {
                alert('Geolocation belum diperoleh. Silakan coba lagi.');
                return false;
            }
            localStorage.setItem('absensiSubmitted', 'true');
            return true;
        }

        document.getElementById('backButton').addEventListener('click', function() {
            if (localStorage.getItem('absensiSubmitted') === 'true') {
                localStorage.removeItem('absensiSubmitted');
                window.location.href = '/welcome';
            } else {
                window.history.back();
            }
        });
    </script>
</body>
</html>
