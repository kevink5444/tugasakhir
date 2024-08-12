<!DOCTYPE html>
<html>
<head>
    <title>Tambah Gaji Bulanan</title>
</head>
<body>
    <h1>Tambah Gaji Bulanan</h1>
    <form action="{{ route('gaji_bulanan.store') }}" method="POST">
        @csrf
        <label for="id_karyawan">Karyawan:</label>
        <select name="id_karyawan" id="id_karyawan">
            @foreach($karyawans as $karyawan)
                <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
            @endforeach
        </select>
        <label for="bulan">Bulan:</label>
        <input type="month" name="bulan" id="bulan" required>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>