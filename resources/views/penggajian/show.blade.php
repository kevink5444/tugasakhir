@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gaji Karyawan</h1>
    <p>Nama Karyawan: {{ $karyawan->nama_karyawan }}</p>
    <p>Email Karyawan: {{ $karyawan->email_karyawan }}</p>
    <p>Target Mingguan: {{ $karyawan->target_mingguan }}</p>
    <p>Target Harian: {{ $karyawan->target_harian }}</p>
    <p>Capaian Mingguan: {{ $capaianMingguan }}</p>
    <p>Bonus: Rp {{ number_format($bonus, 0, ',', '.') }}</p>
    <p>Denda: Rp {{ number_format($denda, 0, ',', '.') }}</p>
    <p>Total Gaji: Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
</div>
@endsection