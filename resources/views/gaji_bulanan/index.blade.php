@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Daftar Gaji Bulanan</h1>
    <a href="{{ route('gaji_bulanan.create') }}" class="btn btn-primary mb-3">Tambah Gaji Bulanan</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Bulan</th>
                <th>Gaji Pokok</th>
                <th>Uang Transport</th>
                <th>Uang Makan</th>
                <th>Bonus</th>
                <th>Denda</th>
                <th>Bonus Lembur</th>
                <th>Total Gaji</th>
                <th>Status Pengambilan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tbody>
                @foreach($gajiBulanan as $gaji)
                <tr>
                    <td>{{ $gaji->karyawan->nama_karyawan }}</td>
                    <td>{{ \Carbon\Carbon::parse($gaji->bulan)->format('F Y') }}</td>
                    <td>{{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                    <td>{{ number_format($gaji->uang_transport, 2) }}</td>
                    <td>{{ number_format($gaji->uang_makan, 2) }}</td>
                    <td>{{ number_format($gaji->bonus, 2) }}</td> 
                    <td>{{ number_format($gaji->denda, 2) }}</td> 
                    <td>{{ number_format($gaji->bonus_lembur, 2) }}</td> 
                    <td>{{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                    <td>{{ $gaji->status_pengambilan ? 'Sudah Diambil' : 'Belum Diambil' }}</td>
        
                <td>
                    <a href="{{ route('gaji_bulanan.cetak_slip', $gaji->id_gaji_bulanan) }}" class="btn btn-info btn-sm">Slip Gaji</a>
                    <a href="{{ route('gaji_bulanan.edit', $gaji->id_gaji_bulanan) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('gaji_bulanan.destroy', $gaji->id_gaji_bulanan) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection