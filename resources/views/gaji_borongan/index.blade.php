@extends('layouts.app')

@section('content')
    <h1>Data Gaji Borongan</h1>
    <a href="{{ route('gaji_borongan.create') }}" class="btn btn-primary">Tambah Gaji Borongan</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Karyawan</th>
                <th>Tanggal</th>
                <th>Pekerjaan</th>
                <th>Jumlah Pekerjaan</th>
                <th>Total Gaji</th>
                <th>Status Pengambilan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gaji_borongan as $gaji)
                <tr>
                    <td>{{ $gaji->id_gaji_borongan }}</td>
                    <td>{{ $gaji->karyawan->nama }}</td>
                    <td>{{ $gaji->tanggal }}</td>
                    <td>{{ $gaji->pekerjaan }}</td>
                    <td>{{ $gaji->jumlah_pekerjaan }}</td>
                    <td>Rp {{ number_format($gaji->total_gaji, 2, ',', '.') }}</td>
                    <td>{{ $gaji->status_pengambilan ? 'Diambil' : 'Belum Diambil' }}</td>
                    <td>
                        <a href="{{ route('gaji_borongan.edit', $gaji->id_gaji_borongan) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('gaji_borongan.destroy', $gaji->id_gaji_borongan) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                        @if(!$gaji->status_pengambilan)
                            <a href="{{ route('gaji_borongan.ambil_gaji', $gaji->id_gaji_borongan) }}" class="btn btn-success">Ambil Gaji</a>
                        @endif
                        <a href="{{ route('gaji_borongan.cetak_slip', $gaji->id_gaji_borongan) }}" class="btn btn-info">Cetak Slip</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection