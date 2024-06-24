@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Data Absensi</h1>
        <a href="{{ route('absensi.form') }}" class="btn btn-primary mb-3">Form Absensi</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->id_karyawan }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->waktu_masuk)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i:s') }}</td>
                        <td>{{ $item->waktu_keluar ? \Carbon\Carbon::parse($item->waktu_keluar)->format('H:i:s') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data absensi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
