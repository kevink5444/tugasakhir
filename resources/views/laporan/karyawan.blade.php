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
                    <th>Email Karyawan</th>
                    <th>Status Karyawan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $item)
                    <tr>
                        <td>{{ $item->id_karyawan }}</td>
                        <td>{{ $item->nama_karyawan }}</td>
                        <td>{{ $item->email_karyawan }}</td>
                        <td>{{ $item->status_karyawan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection