<!DOCTYPE html>
<html>
<head>
    <title>Edit Gaji Bulanan</title>
</head>
<body>
    <h1>Edit Gaji Bulanan</h1>
    <form action="{{ route('gaji_bulanan.update', $gajiBulanan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="bulan">Bulan:</label>
        <input type="month" name="bulan" id="bulan" value="{{ $gajiBulanan->bulan }}" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>
