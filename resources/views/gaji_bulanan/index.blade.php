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
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Karyawan</th>
                <th>Bulan</th>
                <th>Gaji Pokok</th>
                <th>Total Gaji</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gajiBulanan as $gaji)
                <tr>
                    <td>{{ $gaji->id }}</td>
                    <td>{{ $gaji->karyawan->name }}</td>
                    <td>{{ $gaji->bulan }}</td>
                    <td>Rp {{ number_format($gaji->gaji_pokok) }}</td>
                    <td>Rp {{ number_format($gaji->total_gaji) }}</td>
                    <td>
                        @if(!$gaji->is_salary_taken)
                            <a href="{{ route('gaji_bulanan.takeSalary', $gaji->id) }}" class="btn btn-success btn-sm">Ambil Gaji</a>
                        @endif
                        <a href="{{ route('gaji_bulanan.generatePayslip', $gaji->id) }}" class="btn btn-info btn-sm">Slip Gaji</a>
                        <a href="{{ route('gaji_bulanan.edit', $gaji->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('gaji_bulanan.destroy', $gaji->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection