@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Gaji Borongan</h2>

    <!-- Form Filter -->
    <form action="{{ route('gaji_borongan.filter') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <label for="bulan">Pilih Bulan</label>
                <select name="bulan" id="bulan" class="form-control">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach(range(1, 12) as $i)
                        <option value="{{ $i }}" {{ (isset($bulan) && $bulan == $i) ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="tahun">Pilih Tahun</label>
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach(range(date('Y'), 2000) as $year)
                        <option value="{{ $year }}" {{ (isset($tahun) && $tahun == $year) ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2" id="filterBtn">Filter</button>
                <a href="{{ route('gaji_borongan.create') }}" class="btn btn-success">Tambah Gaji Borongan</a>
            </div>
        </div>
    </form>

    <!-- Tabel Data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Gaji</th>
                <th>Karyawan</th>
                <th>Minggu Mulai</th>
                <th>Minggu Selesai</th>
                <th>Capaian Harian</th>
                <th>Bonus Lembur</th>
                <th>Total Denda</th>
                <th>Total Gaji</th>
                <th>Status Pengambilan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="gajiTableBody"> 
            @forelse($gajiBorongan as $gaji)
                <tr>
                    <td>{{ $gaji->id_gaji_borongan }}</td>
                    <td>{{ $gaji->karyawan->nama_karyawan }}</td>
                    <td>{{ \Carbon\Carbon::parse($gaji->minggu_mulai)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($gaji->minggu_selesai)->format('d-m-Y') }}</td>
                    <td>{{ number_format($gaji->capaian_harian, 2, ',', '.') }}</td>
                    <td>{{ number_format($gaji->bonus_lembur, 2, ',', '.') }}</td>
                    <td>{{ number_format($gaji->total_denda, 2, ',', '.') }}</td>
                    <td>{{ number_format($gaji->total_gaji_borongan, 2, ',', '.') }}</td>
                    <td>
                        {{ $gaji->status_pengambilan ? 'Sudah Diambil' : 'Belum Diambil' }}
                    </td>
                    <td>
                        <a href="{{ route('gaji_borongan.edit', $gaji->id_gaji_borongan) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('gaji_borongan.destroy', $gaji->id_gaji_borongan) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                        @if(!$gaji->status_pengambilan)
                            <a href="{{ route('gaji_borongan.ambil_gaji', $gaji->id_gaji_borongan) }}" class="btn btn-success">Ambil Gaji</a>
                        @endif
                        <a href="{{ route('gaji_borongan.cetak_slip', $gaji->id_gaji_borongan) }}" class="btn btn-info">Slip Gaji</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
