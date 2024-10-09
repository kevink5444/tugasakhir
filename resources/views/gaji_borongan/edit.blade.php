@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Gaji Borongan</h1>

    <form action="{{ route('gajiBorongan.update', $gajiBorongan->id_gaji_borongan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id_karyawan" class="form-label">Nama Karyawan</label>
            <select class="form-select" id="id_karyawan" name="id_karyawan" required>
                <option value="">Pilih Karyawan</option>
                @foreach($karyawan as $k)
                    <option value="{{ $k->id }}" {{ $gajiBorongan->id_karyawan == $k->id_karyawan ? 'selected' : '' }}>{{ $k->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="minggu_mulai" class="form-label">Minggu Mulai</label>
            <input type="date" class="form-control" id="minggu_mulai" name="minggu_mulai" value="{{ $gajiBorongan->minggu_mulai }}" required>
        </div>

        <div class="mb-3">
            <label for="minggu_selesai" class="form-label">Minggu Selesai</label>
            <input type="date" class="form-control" id="minggu_selesai" name="minggu_selesai" value="{{ $gajiBorongan->minggu_selesai }}" required>
        </div>

        <div class="mb-3">
            <label for="capaian_harian" class="form-label">Capaian Harian</label>
            <input type="number" class="form-control" id="capaian_harian" name="capaian_harian" value="{{ $gajiBorongan->capaian_harian }}" required>
        </div>

        <div class="mb-3">
            <label for="total_lembur" class="form-label">Total Lembur</label>
            <input type="number" class="form-control" id="total_lembur" name="total_lembur" value="{{ $gajiBorongan->total_lembur }}" required>
        </div>

        <div class="mb-3">
            <label for="bonus_lembur" class="form-label">Bonus Lembur</label>
            <input type="number" class="form-control" id="bonus_lembur" name="bonus_lembur" value="{{ $gajiBorongan->bonus_lembur }}" required>
        </div>

        <div class="mb-3">
            <label for="total_bonus" class="form-label">Total Bonus</label>
            <input type="number" class="form-control" id="total_bonus" name="total_bonus" value="{{ $gajiBorongan->total_bonus }}" required>
        </div>

        <div class="mb-3">
            <label for="total_denda" class="form-label">Total Denda</label>
            <input type="number" class="form-control" id="total_denda" name="total_denda" value="{{ $gajiBorongan->total_denda }}" required>
        </div>

        <div class="mb-3">
            <label for="status_pengambilan" class="form-label">Status Pengambilan</label>
            <input type="text" class="form-control" id="status_pengambilan" name="status_pengambilan" value="{{ $gajiBorongan->status_pengambilan }}" required>
        </div>

        <div class="mb-3">
            <label for="total_gaji_borongan" class="form-label">Total Gaji Borongan (Otomatis)</label>
            <input type="number" class="form-control" id="total_gaji_borongan" name="total_gaji_borongan" value="{{ $gajiBorongan->total_gaji_borongan }}" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

<script>
document.addEventListener('input', function () {
    var capaianHarian = parseFloat(document.getElementById('capaian_harian').value) || 0;
    var totalLembur = parseFloat(document.getElementById('total_lembur').value) || 0;
    var bonusLembur = parseFloat(document.getElementById('bonus_lembur').value) || 0;
    var totalBonus = parseFloat(document.getElementById('total_bonus').value) || 0;
    var totalDenda = parseFloat(document.getElementById('total_denda').value) || 0;

    var totalGajiBorongan = (capaianHarian + totalLembur + bonusLembur) + totalBonus - totalDenda;

    document.getElementById('total_gaji_borongan').value = totalGajiBorongan;
});
</script>
@endsection
