@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Gaji Harian</h1>
    <a href="{{ route('gaji_harian.create') }}" class="btn btn-primary">Tambah Gaji Harian</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Karyawan</th>
                <th>Tanggal</th>
                <th>Jenis Pekerjaan</th>
                <th>Jumlah Pekerjaan</th>
                <th>Target Harian</th>
                <th>Capaian Harian</th>
                <th>Gaji Harian</th>
                <th>Bonus Harian</th>
                <th>Denda Harian</th>
                <th>Status Pengambilan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gaji_harian as $gaji)
                <tr>
                    <td>{{ $gaji->id_gaji_harian }}</td>
                    <td>{{ $gaji->karyawan->nama_karyawan }}</td>
                    <td>{{ $gaji->tanggal }}</td>
                    <td>{{ $gaji->pekerjaan->nama_pekerjaan }}</td>
                    <td>{{ $gaji->jumlah_pekerjaan }}</td>
                    <td>{{ $gaji->target_harian }}</td>
                    <td>{{ $gaji->capaian_harian }}</td>
                    <td>{{ number_format($gaji->gaji_harian, 0, ',', '.') }}</td>
                    <td>{{ number_format($gaji->bonus_harian, 0, ',', '.') }}</td>
                    <td>{{ number_format($gaji->denda_harian, 0, ',', '.') }}</td>
                    <td>{{ $gaji->status_pengambilan ? 'Diambil' : 'Belum Diambil' }}</td>
                    <td>
                        @if(!$gaji->status_pengambilan)
                            <a href="{{ route('gaji_harian.ambil_gaji', $gaji->id_gaji_harian) }}" class="btn btn-success btn-sm">Ambil Gaji</a>
                        @endif
                        <a href="{{ route('gaji_harian.edit', $gaji->id_gaji_harian) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('gaji_harian.destroy', $gaji->id_gaji_harian) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                        <a href="{{ route('gaji_harian.cetak_slip', $gaji->id_gaji_harian) }}" class="btn btn-info btn-sm">Slip Gaji</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
