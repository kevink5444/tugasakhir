@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Gaji Borongan</h1>
    <a href="{{ route('gaji_borongan.create') }}" class="btn btn-primary mb-3">Tambah Gaji Borongan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Karyawan</th>
                <th>Minggu Mulai</th>
                <th>Minggu Selesai</th>
                <th>Total Gaji Borongan</th>
                <th>Total Bonus</th>
                <th>Total Denda</th>
                <th>Status Pengambilan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gaji_borongan as $gaji)
                <tr>
                    <td>{{ $gaji->id_gaji_borongan }}</td>
                    <td>{{ $gaji->karyawan->nama_karyawan }}</td>
                    <td>{{ $gaji->minggu_mulai }}</td>
                    <td>{{ $gaji->minggu_selesai }}</td>
                    <td>{{ $gaji->total_gaji_borongan }}</td>
                    <td>{{ $gaji->total_bonus }}</td>
                    <td>{{ $gaji->total_denda }}</td>
                    <td>{{ $gaji->status_pengambilan ? 'Sudah Diambil' : 'Belum Diambil' }}</td>
                    <td>
                        <a href="{{ route('gaji_borongan.edit', $gaji->id_gaji_borongan) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('gaji_borongan.destroy', $gaji->id_gaji_borongan) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        <a href="{{ route('gaji_borongan.cetak_slip', $gaji->id_gaji_borongan) }}" class="btn btn-info btn-sm">Slip Gaji</a>
                        @if (!$gaji->status_pengambilan)
                            <form action="{{ route('gaji_borongan.ambil_gaji', $gaji->id_gaji_borongan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm">Ambil Gaji</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
