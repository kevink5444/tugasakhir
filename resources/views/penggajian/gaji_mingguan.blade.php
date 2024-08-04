@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Gaji Mingguan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Minggu Mulai</th>
                    <th>Minggu Selesai</th>
                    <th>Total Gaji Mingguan</th>
                    <th>Total Bonus</th>
                    <th>Total Denda</th>
                    <th>Total Pekerjaan</th>
                    <th>Total Lembur</th>
                    <th>Bonus Lembur</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gaji_mingguan as $gaji)
                    <tr>
                        <td>{{ $gaji->id_karyawan }}</td>
                        <td>{{ $gaji->karyawan->nama_karyawan }}</td>
                        <td>{{ $gaji->minggu_mulai->format('d-m-Y') }}</td>
                        <td>{{ $gaji->minggu_selesai->format('d-m-Y') }}</td>
                        <td>{{ number_format($gaji->total_gaji_mingguan, 2) }}</td>
                        <td>{{ number_format($gaji->total_bonus, 2) }}</td>
                        <td>{{ number_format($gaji->total_denda, 2) }}</td>
                        <td>{{ $gaji->total_pekerjaan }}</td>
                        <td>{{ number_format($gaji->total_lembur, 2) }}</td>
                        <td>{{ number_format($gaji->bonus_lembur, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection