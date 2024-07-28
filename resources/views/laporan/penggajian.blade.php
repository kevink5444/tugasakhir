@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Laporan Penggajian</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Penggajian</th>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Gaji Pokok</th>
                    <th>Bonus Absensi</th>
                    <th>Bonus Pekerjaan</th>
                    <th>Lembur</th>
                    <th>Denda</th>
                    <th>Total Gaji</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penggajian as $item)
                    <tr>
                        <td>{{ $item->id_penggajian }}</td>
                        <td>{{ $item->id_karyawan }}</td>
                        <td>{{ $item->karyawan->nama_karyawan }}</td>
                        <td>{{ $item->gaji_pokok }}</td>
                        <td>{{ $item->bonus_absensi }}</td>
                        <td>{{ $item->bonus_pekerjaan }}</td>
                        <td>{{ $item->hitungLembur($item->id_karyawan) }}</td>
                        <td>{{ $item->denda }}</td>
                        <td>{{ $item->total_gaji }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection