@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Gaji Harian</h2>
    <a href="{{ route('gaji_harian.create') }}" class="btn btn-primary">Tambah Gaji Harian</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Karyawan</th>
                <th>Nama Pekerjaan</th>
                <th>Tanggal Awal</th>
                <th>Tanggal Akhir</th>
                <th>Target Harian</th>
                <th>Capaian Harian</th>
                <th>Gaji Harian</th>
                <th>Total Gaji Mingguan</th>
                <th>Bonus Harian</th>
                <th>Denda Harian</th>
                <th>Status Pengambilan</th>
                <th>Aksi</th> <!-- Tambahkan kolom aksi -->
            </tr>
        </thead>
        <tbody>
            @forelse($gajiHarian as $gaji)
            <tr>
                <td>{{ $gaji->id_gaji_harian }}</td>
                <td>{{ $gaji->karyawan->nama_karyawan }}</td> <!-- Asumsi Anda memiliki relasi dengan model Karyawan -->
                <td>{{ $gaji->pekerjaan->nama_pekerjaan }}</td> <!-- Asumsi Anda memiliki relasi dengan model Pekerjaan -->
                <td>{{ $gaji->tanggal_awal }}</td>
                <td>{{ $gaji->tanggal_akhir }}</td>
                <td>{{ $gaji->target_harian }}</td>
                <td>{{ $gaji->capaian_harian }}</td>
                <td>{{ $gaji->gaji_harian }}</td>
                <td>{{ $gaji->gaji_harian * 6 }}</td> <!-- Total gaji seminggu -->
                <td>{{ $gaji->bonus_harian }}</td>
                <td>{{ $gaji->denda_harian }}</td>
                <td>{{ $gaji->status_pengambilan == 0 ? 'Belum Diambil' : 'Sudah Diambil' }}</td>
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
            @empty
            <tr>
                <td colspan="13" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
