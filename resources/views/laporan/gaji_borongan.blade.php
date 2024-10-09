@extends('layouts.app')

@section('content')
    <h1>Laporan Gaji Borongan</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID Karyawan</th>
                <th>Total Gaji</th>
                <th>Bulan</th>
                <th>Tahun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $data)
            <tr>
                <td>{{ $data->id_karyawan }}</td>
                <td>{{ $data->total_gaji }}</td>
                <td>{{ $data->bulan }}</td>
                <td>{{ $data->tahun }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
