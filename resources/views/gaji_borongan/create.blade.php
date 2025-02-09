@extends('layouts.app')  <!-- Atau layout yang Anda gunakan -->

@section('content')
<div class="container">
    <h3>Tambah Gaji Borongan</h3>

    <form id="form_gaji_borongan" method="POST" action="{{ route('gaji_borongan.store') }}">
        @csrf

        <!-- Input ID Karyawan -->
        <label for="id_karyawan">ID Karyawan:</label>
        <select id="id_karyawan" name="id_karyawan" required>
            <option value="">Pilih Karyawan</option>
            @foreach ($karyawan as $karyawan)
                <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama_karyawan }}</option>
            @endforeach
        </select>

        <!-- Input Gaji Per Hari -->
        <label for="gaji_per_hari">Gaji Per Hari:</label>
        <input type="number" id="gaji_per_hari" name="gaji_per_hari" placeholder="Masukkan Gaji Per Hari" required>

        <!-- Input Capaian Harian -->
        <label for="capaian_harian">Capaian Harian:</label>
        <input type="number" id="capaian_harian" name="capaian_harian" placeholder="Masukkan Capaian Harian" required>

        <!-- Input Total Lembur -->
        <label for="total_lembur">Total Lembur (Jam):</label>
        <input type="number" id="total_lembur" name="total_lembur" placeholder="Masukkan Jam Lembur" required>

        <!-- Bonus Lembur -->
        <label for="bonus_lembur">Bonus Lembur:</label>
        <input type="number" id="bonus_lembur" name="bonus_lembur" readonly>

        <!-- Total Bonus -->
        <label for="total_bonus">Total Bonus:</label>
        <input type="number" id="total_bonus" name="total_bonus" readonly>

        <!-- Total Denda -->
        <label for="total_denda">Total Denda:</label>
        <input type="number" id="total_denda" name="total_denda" readonly>

        <!-- Total Gaji Borongan -->
        <label for="total_gaji_borongan">Total Gaji Borongan:</label>
        <input type="number" id="total_gaji_borongan" name="total_gaji_borongan" readonly>

        <!-- Submit Button -->
        <button type="submit">Simpan Gaji Borongan</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Event Listener saat ID Karyawan berubah
    document.getElementById('id_karyawan').addEventListener('change', async function () {
        var idKaryawan = this.value;

        if (idKaryawan) {
            // Ambil Capaian Harian, Bonus dan Denda dari API
            const capaianHarian = await getCapaianHarian(idKaryawan);
            document.getElementById('capaian_harian').value = capaianHarian;

            const totalBonus = await calculateBonusAbsensi(idKaryawan);
            document.getElementById('total_bonus').value = totalBonus;

            const totalDenda = await calculateDendaAbsensi(idKaryawan);
            document.getElementById('total_denda').value = totalDenda;
        }
    });

    // Event Listener untuk menghitung lembur
    document.getElementById('total_lembur').addEventListener('input', function () {
        var totalLembur = parseFloat(this.value) || 0;
        var gajiPerHari = parseFloat(document.getElementById('gaji_per_hari').value) || 0;
        var bonusLembur = (gajiPerHari / 8) * totalLembur; // Gaji lembur dihitung per jam
        document.getElementById('bonus_lembur').value = bonusLembur;

        var capaianHarian = parseFloat(document.getElementById('capaian_harian').value) || 0;
        var totalBonus = parseFloat(document.getElementById('total_bonus').value) || 0;
        var totalDenda = parseFloat(document.getElementById('total_denda').value) || 0;

        // Perhitungan Total Gaji Borongan
        var totalGajiBorongan = (capaianHarian + bonusLembur + totalBonus) - totalDenda;
        document.getElementById('total_gaji_borongan').value = totalGajiBorongan;
    });

    // Fungsi untuk mengambil capaian harian dari backend
    async function getCapaianHarian(idKaryawan) {
        const response = await fetch(`/get-capaian/${idKaryawan}`);
        const data = await response.json();
        return data.capaian_harian;
    }

    // Fungsi untuk menghitung bonus absensi dari backend
    async function calculateBonusAbsensi(idKaryawan) {
        const response = await fetch(`/get-absensi-bonus/${idKaryawan}`);
        const data = await response.json();
        return data.total_bonus;
    }

    // Fungsi untuk menghitung denda absensi dari backend
    async function calculateDendaAbsensi(idKaryawan) {
        const response = await fetch(`/get-absensi-denda/${idKaryawan}`);
        const data = await response.json();
        return data.total_denda;
    }
</script>
@endsection
