@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Lembur</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID Karyawan</th>
                <th>Jam Lembur</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lembur as $item)
                <tr>
                    <td>{{ $item->id_karyawan }}</td>
                    <td>{{ $item->jam_lembur }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->status_lembur }}</td>
                    <td>
                        @if($item->status_lembur == 'Pending')
                            <a href="{{ route('lembur.approve', $item->id) }}" class="btn btn-success">Setujui</a>
                            <a href="{{ route('lembur.reject', $item->id) }}" class="btn btn-danger">Tolak</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection