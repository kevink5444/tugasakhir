@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Laporan Data Karyawan</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Alamat</th>
                    <th>Jenis Karyawan</th>
                    <th>Posisi</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $item)
                    <tr>
                        <td>{{ $item->id_karyawan }}</td>
                        <td>{{ $item->nama_karyawan }}</td>
                        <td>{{ $item->alamat_karyawan }}</td>
                        <td>{{ $item->jenis_karyawan }}</td>
                        <td>{{ $item->posisi }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->tanggal_masuk)) }}</td>
                        <td>{{ $item->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
