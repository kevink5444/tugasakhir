@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Absensi</h2>
    <a href="{{ route('absensi.create') }}" class="btn btn-primary mb-3">Tambah Absensi</a>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID_Absensi</th>
                <th>ID_Karyawan</th>
                <th>Status</th>
                <th>Waktu Masuk</th>
                <th>Waktu Pulang</th>
                <th>Bonus</th>
                <th>Denda</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensi as $item)
                <tr>
                    <td>{{ $item->id_absensi }}</td>
                    <td>{{ $item->karyawan->id_karyawan }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->waktu_masuk }}</td>
                    <td>{{ $item->waktu_pulang }}</td>
                    <td>Rp {{ number_format($item->bonus, 2, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->denda, 2, ',', '.') }}</td>
                    <td>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection