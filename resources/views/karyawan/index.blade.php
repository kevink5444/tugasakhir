@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Data Karyawan</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align: center;">ID</th>
                    <th style="text-align: center;">Nama</th>
                    <th style="text-align: center;">Email</th>
                    <th style="text-align: center;">Alamat</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Created At</th>
                    <th style="text-align: center;">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($karyawan as $item)
                    <tr>
                        <td style="text-align: center;">{{ $item->id_karyawan }}</td>
                        <td style="text-align: center;">{{ $item->nama_karyawan }}</td>
                        <td style="text-align: center;">{{ $item->email }}</td>
                        <td style="text-align: center;">{{ $item->alamat_karyawan }}</td>
                        <td style="text-align: center;">{{ $item->status }}</td>
                        <td style="text-align: center;">{{ $item->created_at ? $item->created_at->format('d-m-Y H:i') : 'N/A' }}</td>
                        <td style="text-align: center;">{{ $item->updated_at ? $item->updated_at->format('d-m-Y H:i') : 'N/A' }}</td>
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
