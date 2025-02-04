@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Gaji Harian</h1>

    <!-- Form Filter -->
    <form action="{{ route('gaji-harian.filter') }}" method="GET" class="mb-3">
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
                <a href="{{ route('gaji_harian.create') }}" class="btn btn-success">Tambah Gaji Harian</a>
        </div>
    </form>

    <!-- Tabel Data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Jumlah Gaji</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gajiHarian as $key => $data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->karyawan->nama_karyawan }}</td> <!-- Sesuaikan relasi jika ada -->
                    <td>{{ $data->tanggal_akhir }}</td>
                    <td>{{ number_format($data->total_gaji, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
