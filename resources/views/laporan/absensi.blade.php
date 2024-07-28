@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Laporan Absensi</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Email</th>
                    <th>Foto</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absensi as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->id_karyawan }}</td>
                        <td>{{ $item->karyawan->nama_karyawan }}</td>
                        <td>{{ $item->email }}</td>
                        <td><img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" width="50"></td>
                        <td>{{ $item->latitude }}</td>
                        <td>{{ $item->longitude }}</td>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        <td>{{ $item->created_at->format('H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection