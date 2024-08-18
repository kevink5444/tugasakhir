@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Gaji Harian</h2>

    <form id="gajiHarianForm" action="{{ route('gaji_harian.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_karyawan">Nama Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                <option value="" disabled selected>Pilih Karyawan</option>
                @foreach($karyawan as $karyawan)
                <option value="{{ $karyawan->id_karyawan }}" data-position="{{ $karyawan->position }}" {{ old('id_karyawan') == $karyawan->id_karyawan ? 'selected' : '' }}>
                    {{ $karyawan->nama_karyawan }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal_awal">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="tanggal_akhir">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="id_pekerjaan">Pekerjaan</label>
            <select name="id_pekerjaan" id="id_pekerjaan" class="form-control" required>
                @foreach($pekerjaan as $p)
                    <option value="{{ $p->id_pekerjaan }}" 
                        data-gaji="{{ $p->gaji_per_unit }}" 
                        data-target="{{ $p->target_harian }}">
                        {{ $p->nama_pekerjaan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="jumlah_pekerjaan">Jumlah Pekerjaan</label>
            <input type="number" name="jumlah_pekerjaan" id="jumlah_pekerjaan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="capaian_harian">Capaian Harian</label>
            <input type="number" name="capaian_harian" id="capaian_harian" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="target_harian">Target Harian</label>
            <input type="text" id="target_harian" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="gaji_harian">Gaji Harian</label>
            <input type="text" id="gaji_harian" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="bonus_harian">Bonus Harian</label>
            <input type="text" id="bonus_harian" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="denda_harian">Denda Harian</label>
            <input type="text" id="denda_harian" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pekerjaanSelect = document.getElementById('id_pekerjaan');
    const jumlahPekerjaanInput = document.getElementById('jumlah_pekerjaan');
    const capaianHarianInput = document.getElementById('capaian_harian');
    const targetHarianInput = document.getElementById('target_harian');
    const gajiHarianInput = document.getElementById('gaji_harian');
    const bonusHarianInput = document.getElementById('bonus_harian');
    const dendaHarianInput = document.getElementById('denda_harian');

    function updateGaji() {
        const selectedOption = pekerjaanSelect.options[pekerjaanSelect.selectedIndex];
        const gajiPerPekerjaan = parseFloat(selectedOption.getAttribute('data-gaji'));
        const targetHarian = parseFloat(selectedOption.getAttribute('data-target'));
        const jumlahPekerjaan = parseFloat(jumlahPekerjaanInput.value) || 0;
        const capaianHarian = parseFloat(capaianHarianInput.value) || 0;

        // Hitung gaji harian
        const gajiHarian = jumlahPekerjaan * gajiPerPekerjaan;

        // Hitung bonus dan denda
        let bonusHarian = 0;
        let dendaHarian = 0;

        if (capaianHarian >= targetHarian) {
            bonusHarian = gajiHarian * 0.2; // 20% dari gaji harian
        }

        if (jumlahPekerjaan < targetHarian) {
            dendaHarian = gajiHarian * 0.05; // 5% dari gaji harian
        }

        // Update input fields
        targetHarianInput.value = `Rp ${targetHarian.toFixed(0)}`;
        gajiHarianInput.value = `Rp ${gajiHarian.toFixed(0)}`;
        bonusHarianInput.value = `Rp ${bonusHarian.toFixed(0)}`;
        dendaHarianInput.value = `Rp ${dendaHarian.toFixed(0)}`;
    }

    pekerjaanSelect.addEventListener('change', updateGaji);
    jumlahPekerjaanInput.addEventListener('input', updateGaji);
    capaianHarianInput.addEventListener('input', updateGaji);
    updateGaji(); // Initial calculation based on default values
});
</script>
@endsection
