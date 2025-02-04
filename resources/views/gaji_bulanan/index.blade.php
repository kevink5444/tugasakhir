@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Daftar Gaji Bulanan</h1>

    <!-- Form Filter -->
    <form action="{{ route('gaji_bulanan.filter') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <label for="bulan" class="form-label">Bulan</label>
                <select name="bulan" id="bulan" class="form-select">
                    <option value="">Semua Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label for="tahun" class="form-label">Tahun</label>
                <select name="tahun" id="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @php
                        $currentYear = now()->year;
                    @endphp
                    @for($year = $currentYear; $year >= ($currentYear - 5); $year--)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('gaji_bulanan.create') }}" class="btn btn-success ms-2">Tambah Gaji Bulanan</a>
            </div>
        </div>
    </form>

    <!-- Tabel Gaji Bulanan -->
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
            @forelse($gajiBulanan as $gaji)
            <tr>
                <td>{{ $gaji->karyawan->nama_karyawan }}</td>
                <td>{{ \Carbon\Carbon::parse($gaji->bulan)->translatedFormat('F Y') }}</td>
                <td>{{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                <td>{{ number_format($gaji->uang_transport, 0, ',', '.') }}</td>
                <td>{{ number_format($gaji->uang_makan, 0, ',', '.') }}</td>
                <td>{{ number_format($gaji->bonus, 0, ',', '.') }}</td>
                <td>{{ number_format($gaji->denda, 0, ',', '.') }}</td>
                <td>{{ number_format($gaji->bonus_lembur, 0, ',', '.') }}</td>
                <td>{{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                <td>{{ $gaji->status_pengambilan ? 'Sudah Diambil' : 'Belum Diambil' }}</td>
                <td>
                    <a href="{{ route('gaji_bulanan.cetak_slip', $gaji->id_gaji_bulanan) }}" class="btn btn-info btn-sm">Slip Gaji</a>
                    <a href="{{ route('gaji_bulanan.edit', $gaji->id_gaji_bulanan) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('gaji_bulanan.destroy', $gaji->id_gaji_bulanan) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center">Tidak ada data gaji bulanan yang tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
