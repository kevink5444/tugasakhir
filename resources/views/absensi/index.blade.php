@extends('layouts.app')


@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Data Absensi</h1>
        <a href="{{ route('absensi.form') }}" class="btn btn-primary mb-3">Form Absensi</a>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <thead>
                <tr>
                    <th>Id Absensi</th>
                    <th>Email</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Bonus</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->email_karyawan }}</td>
                    <td>{{ $item->karyawan->nama_karyawan }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->jam_masuk)->format('H:i:s') }}</td>
                    <td>{{ $item->bonus }}</td>
                    <td>{{ $item->denda }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data absensi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
