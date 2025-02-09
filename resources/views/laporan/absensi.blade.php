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
                    <th>Status</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Pulang</th>
                    <th>Tanggal</th>
                    <th>Denda</th>
                    <th>Bonus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absensi as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->id_karyawan }}</td>
                        <td>{{ $item->karyawan->nama_karyawan }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>
                            {{ $item->waktu_masuk ? \Carbon\Carbon::parse($item->waktu_masuk)->format('d-m-Y H:i') : '-' }}
                        </td>
                        <td>
                            {{ $item->waktu_pulang ? \Carbon\Carbon::parse($item->waktu_pulang)->format('d-m-Y H:i') : '-' }}
                        </td>
                        <td>
                            {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}
                        </td>
                        <td>{{ number_format($item->denda ?? 0, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->bonus ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
