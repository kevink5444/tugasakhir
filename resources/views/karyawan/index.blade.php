@extends('layouts.app')

@section('content')
<a href="{{ route('karyawan.create') }}"class="btn btn-primary">Tambah Karyawan</a>
<div class="container">
    <h1 class="my-4 text-center">Data Karyawan</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align: center;">ID Karyawan</th>
                    <th style="text-align: center;">Nama</th>
                    <th style="text-align: center;">Email</th>
                    <th style="text-align: center;">Alamat</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Created At</th>
                    <th style="text-align: center;">Updated At</th>
                    <th style="text-align: center;">Tombol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($karyawan as $karyawan)
                    <tr>
                        <td style="text-align: center;">{{ $karyawan->id_karyawan }}</td>
                        <td style="text-align: center;">{{ $karyawan->nama_karyawan }}</td>
                        <td style="text-align: center;">{{ $karyawan->email }}</td>
                        <td style="text-align: center;">{{ $karyawan->alamat_karyawan }}</td>
                        <td style="text-align: center;">{{ $karyawan->status }}</td>
                        <td style="text-align: center;">{{ $karyawan->created_at ? $karyawan->created_at->format('d-m-Y H:i') : 'N/A' }}</td>
                        <td style="text-align: center;">{{ $karyawan->updated_at ? $karyawan->updated_at->format('d-m-Y H:i') : 'N/A' }}</td>

                        <td>
                            <a href="{{ route('karyawan.edit', $karyawan->id_karyawan) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('karyawan.destroy', $karyawan->id_karyawan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .table thead th {
        vertical-align: middle;
        text-align: center;
    }

    .table tbody td {
        vertical-align: middle;
        text-align: center;
    }

    .table th, .table td {
        padding: 15px;
    }

    .table th {
        background-color: #343a40;
        color: white;
    }

    .table-responsive {
        margin-top: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
</style>
@endsection
