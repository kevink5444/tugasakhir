@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Gaji Bulanan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Bulan</th>
                    <th>Gaji Pokok</th>
                    <th>Uang Transport</th>
                    <th>Uang Makan</th>
                    <th>Bonus</th>
                    <th>THR</th>
                    <th>Total Gaji</th>
                    <th>Total Lembur</th>
                    <th>Bonus Lembur</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gaji_bulanan as $gaji)
                    <tr>
                        <td>{{ $gaji->id_karyawan }}</td>
                        <td>{{ $gaji->karyawan->nama_karyawan }}</td>
                        <td>{{ $gaji->bulan->format('F Y') }}</td>
                        <td>{{ number_format($gaji->gaji_pokok, 2) }}</td>
                        <td>{{ number_format($gaji->uang_transport, 2) }}</td>
                        <td>{{ number_format($gaji->uang_makan, 2) }}</td>
                        <td>{{ number_format($gaji->bonus, 2) }}</td>
                        <td>{{ number_format($gaji->thr, 2) }}</td>
                        <td>{{ number_format($gaji->total_gaji, 2) }}</td>
                        <td>{{ number_format($gaji->total_lembur, 2) }}</td>
                        <td>{{ number_format($gaji->bonus_lembur, 2) }}</td>
                        <td>{{ number_format($gaji->denda, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection