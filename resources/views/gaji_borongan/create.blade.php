@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Gaji Borongan</h1>

    <form action="{{ route('gajiBorongan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_karyawan" class="form-label">Nama Karyawan</label>
            <select class="form-select" id="id_karyawan" name="id_karyawan" required>
                <option value="">Pilih Karyawan</option>
                @foreach($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}">{{ $k->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_pekerjaan" class="form-label">Pekerjaan</label>
            <select class="form-select" id="id_pekerjaan" name="id_pekerjaan" required>
                <option value="">Pilih Pekerjaan</option>
                @foreach($pekerjaan as $p)
                    <option value="{{ $p->id_pekerjaan }}" 
                            data-target="{{ $p->target_harian }}" 
                            data-gaji="{{ $p->gaji_per_pekerjaan }}">
                        {{ $p->nama_pekerjaan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="minggu_mulai" class="form-label">Minggu Mulai</label>
            <input type="date" class="form-control" id="minggu_mulai" name="minggu_mulai" required>
        </div>

        <div class="mb-3">
            <label for="minggu_selesai" class="form-label">Minggu Selesai</label>
            <input type="date" class="form-control" id="minggu_selesai" name="minggu_selesai" required>
        </div>

        <div class="mb-3">
            <label for="capaian_harian" class="form-label">Capaian Harian</label>
            <input type="number" class="form-control" id="capaian_harian" name="capaian_harian" required>
        </div>

        <div class="mb-3">
            <label for="total_lembur" class="form-label">Total Lembur (Jam)</label>
            <input type="number" class="form-control" id="total_lembur" name="total_lembur" value="0" required>
        </div>

        <div class="mb-3">
            <label for="bonus_lembur" class="form-label">Bonus Lembur (Otomatis)</label>
            <input type="number" class="form-control" id="bonus_lembur" name="bonus_lembur" readonly>
        </div>

        <div class="mb-3">
            <label for="total_bonus" class="form-label">Total Bonus (Otomatis)</label>
            <input type="number" class="form-control" id="total_bonus" name="total_bonus" readonly>
        </div>

        <div class="mb-3">
            <label for="total_denda" class="form-label">Total Denda (Otomatis)</label>
            <input type="number" class="form-control" id="total_denda" name="total_denda" readonly>
        </div>

        <div class="mb-3">
            <label for="total_gaji_borongan" class="form-label">Total Gaji Borongan (Otomatis)</label>
            <input type="number" class="form-control" id="total_gaji_borongan" name="total_gaji_borongan" readonly>
        </div>

        <div class="mb-3">
            <label for="status_pengambilan" class="form-label">Status Pengambilan</label>
            <select class="form-select" id="status_pengambilan" name="status_pengambilan" required>
                <option value="Belum Diambil">Belum Diambil</option>
                <option value="Sudah Diambil">Sudah Diambil</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Gaji Borongan</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const idPekerjaan = document.getElementById("id_pekerjaan");
    const capaianHarian = document.getElementById("capaian_harian");
    const totalLembur = document.getElementById("total_lembur");
    const bonusLembur = document.getElementById("bonus_lembur");
    const totalBonus = document.getElementById("total_bonus");
    const totalDenda = document.getElementById("total_denda");
    const totalGaji = document.getElementById("total_gaji_borongan");

    idPekerjaan.addEventListener("change", hitungGaji);
    capaianHarian.addEventListener("input", hitungGaji);
    totalLembur.addEventListener("input", hitungGaji);

    function hitungGaji() {
        let pekerjaan = idPekerjaan.options[idPekerjaan.selectedIndex];
        let targetHarian = parseInt(pekerjaan.getAttribute("data-target")) || 0;
        let gajiPerPekerjaan = parseFloat(pekerjaan.getAttribute("data-gaji")) || 0;
        let capaian = parseInt(capaianHarian.value) || 0;
        let lembur = parseInt(totalLembur.value) || 0;

        // Hitung gaji borongan (capaian harian x gaji per pekerjaan)
        let gajiBorongan = capaian * gajiPerPekerjaan;

        // Hitung bonus absensi (Rp25.000 jika capaian >= target)
        let bonus = capaian >= targetHarian ? 25000 : 0;

        // Hitung denda absensi (Rp10.000 jika capaian < target)
        let denda = capaian < targetHarian ? 10000 : 0;

        // Hitung bonus lembur (gaji sehari dibagi 8 jam x lembur)
        let bonusLemburTotal = (gajiPerPekerjaan * targetHarian / 8) * lembur;

        // Hitung total gaji (gaji borongan + bonus lembur + bonus - denda)
        let totalGajiBorongan = gajiBorongan + bonusLemburTotal + bonus - denda;

        // Masukkan ke input form
        totalGaji.value = totalGajiBorongan.toFixed(2);
        totalBonus.value = bonus;
        totalDenda.value = denda;
        bonusLembur.value = bonusLemburTotal.toFixed(2);
    }
});
</script>
@endsection
