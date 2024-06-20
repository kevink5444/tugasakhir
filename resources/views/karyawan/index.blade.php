@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data Karyawan</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawan as $karyawan)
                <tr>
                    <td>{{ $karyawan->id_karyawan }}</td>
                    <td>{{ $karyawan->nama_karyawan }}</td>
                    <td>{{ $karyawan->email }}</td>
                    <td>{{ $karyawan->alamat_karyawan }}</td>
                    <td>{{ $karyawan->status }}</td>
                    <td>{{ $karyawan->created_at }}</td>
                    <td>{{ $karyawan->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
