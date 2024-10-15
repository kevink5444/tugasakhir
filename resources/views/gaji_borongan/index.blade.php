@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Gaji Borongan</h1>
    <a href="{{ route('gaji_borongan.create') }}" class="btn btn-primary">Tambah Gaji Borongan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Karyawan</th>
                <th>Minggu Mulai</th>
                <th>Minggu Selesai</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Total Gaji</th>
                <th>Status Pengambilan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gajiBorongan as $gaji)
                <tr>
                    <td>{{ $gaji->id_gaji_borongan }}</td> <!-- Menggunakan $loop->iteration untuk nomor urut -->
                    <td>{{ $gaji->karyawan->nama_karyawan }}</td>
                    <td>{{ \Carbon\Carbon::parse($gaji->minggu_mulai)->format('d-m-Y') }}</td> <!-- Format tanggal -->
                    <td>{{ \Carbon\Carbon::parse($gaji->minggu_selesai)->format('d-m-Y') }}</td> <!-- Format tanggal -->
                    <td>{{ $gaji->bulan }}</td>
                    <td>{{ $gaji->tahun }}</td>
                    <td>{{ number_format($gaji->total_gaji_borongan, 2, ',', '.') }}</td> <!-- Format angka -->
                    <td>{{ $gaji->status_pengambilan }}</td>
                    <td>
                        <a href="{{ route('gaji_borongan.edit', [$gaji->id_gaji_borongan]) }}" class="btn btn-primary">Edit</a>


                        <form action="{{ route('gaji_borongan.destroy', $gaji->id_gaji_borongan) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                        @if(!$gaji->status_pengambilan)
                        <a href="{{ route('gaji_borongan.ambil_gaji', $gaji->id_gaji_borongan) }}" class="btn btn-success">Ambil Gaji</a>
                        @endif
                        <a href="{{ route('gaji_borongan.cetak_slip', $gaji->id_gaji_borongan) }}" class="btn btn-info">Cetak Slip</a>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection