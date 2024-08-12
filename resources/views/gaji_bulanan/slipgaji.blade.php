<!DOCTYPE html>
<html>
<head>
    <title>Slip Gaji</title>
</head>
<body>
    <h1>Slip Gaji Bulanan</h1>
    <p>ID: {{ $gajiBulanan->id }}</p>
    <p>Karyawan: {{ $gajiBulanan->karyawan->name }}</p>
    <p>Bulan: {{ $gajiBulanan->bulan }}</p>
    <p>Gaji Pokok: Rp {{ number_format($gajiBulanan->gaji_pokok) }}</p>
    <p>Total Gaji: Rp {{ number_format($gajiBulanan->total_gaji) }}</p>
    <p>Bonus: Rp {{ number_format($gajiBulanan->bonus) }}</p>
    <p>THR: Rp {{ number_format($gajiBulanan->thr) }}</p>
    <p>Total Lembur: Rp {{ number_format($gajiBulanan->total_lembur) }}</p>
    <p>Bonus Lembur: Rp {{ number_format($gajiBulanan->bonus_lembur) }}</p>
    <p>Denda: Rp {{ number_format($gajiBulanan->denda) }}</p>
</body>
</html>
