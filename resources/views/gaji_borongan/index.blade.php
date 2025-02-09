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
                    <th>Bulan</th>
                    <th>Tahun</th>
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
                        <td>{{ $gaji->bulan }}</td>
                        <td>{{ $gaji->tahun }}</td>
                        <td>{{ number_format($gaji->total_gaji_borongan, 2, ',', '.') }}</td>
                        <td>{{ $gaji->status_pengambilan }}</td>
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
                        <td colspan="9" class="text-center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endsection

@section('styles')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.getElementById('waktu_masuk').addEventListener('change', function () {
    const waktuMasuk = this.value;
    const jamMasukTepat = "08:00:00";
    let bonus = 0, denda = 0;

    if (waktuMasuk <= jamMasukTepat) {
        bonus = 25000; // Hadir tepat waktu
    } else {
        denda = 10000; // Terlambat
    }

    const gajiPerHari = parseFloat(document.getElementById('gaji_per_hari').value) || 0;
    const jamLembur = parseFloat(document.getElementById('jam_lembur').value) || 0;
    const gajiPerJam = gajiPerHari / 8;
    const lembur = gajiPerJam * jamLembur;

    const totalGaji = gajiPerHari + bonus - denda + lembur;

    document.getElementById('bonus').value = bonus;
    document.getElementById('denda').value = denda;
    document.getElementById('total_gaji').value = totalGaji;
});
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('id_karyawan').addEventListener('change', async function () {
        var idKaryawan = this.value;

        if (idKaryawan) {
            const capaianHarian = await getCapaianHarian(idKaryawan);
            document.getElementById('capaian_harian').value = capaianHarian;

            const totalBonus = await calculateBonusAbsensi(idKaryawan);
            document.getElementById('total_bonus').value = totalBonus;

            const totalDenda = await calculateDendaAbsensi(idKaryawan);
            document.getElementById('total_denda').value = totalDenda;
        }
    });

    document.getElementById('total_lembur').addEventListener('input', function () {
        var totalLembur = parseFloat(this.value) || 0;
        var gajiPerHari = 100000; // Gaji harian yang ditetapkan
        var bonusLembur = (gajiPerHari / 8) * totalLembur;
        document.getElementById('bonus_lembur').value = bonusLembur;

        var capaianHarian = parseFloat(document.getElementById('capaian_harian').value) || 0;
        var totalBonus = parseFloat(document.getElementById('total_bonus').value) || 0;
        var totalDenda = parseFloat(document.getElementById('total_denda').value) || 0;

        var totalGajiBorongan = (capaianHarian + bonusLembur + totalBonus) - totalDenda;
        document.getElementById('total_gaji_borongan').value = totalGajiBorongan;
    });
});

async function getCapaianHarian(idKaryawan) {
    const response = await fetch(`/get-capaian/${idKaryawan}`);
    const data = await response.json();
    return data.capaian_harian;
}

async function calculateBonusAbsensi(idKaryawan) {
    const response = await fetch(`/get-absensi-bonus/${idKaryawan}`);
    const data = await response.json();
    return data.total_bonus;
}

async function calculateDendaAbsensi(idKaryawan) {
    const response = await fetch(`/get-absensi-denda/${idKaryawan}`);
    const data = await response.json();
    return data.total_denda;
}
</script>