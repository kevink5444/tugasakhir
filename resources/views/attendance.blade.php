

<!DOCTYPE html>
<html>
<head>
    <title>QR Code Absensi</title>
</head>
<body>
    <div>
        {!! QrCode::size(250)->generate(url('/attendance/clock-in?user_id=1')) !!}
    </div>
</body>
</html>
