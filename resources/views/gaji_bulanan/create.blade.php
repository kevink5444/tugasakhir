@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Gaji Bulanan</h1>
    <form action="{{ route('gaji_bulanan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_karyawan">Nama Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                <option value="" disabled selected>Pilih Karyawan</option>
                @foreach($karyawans as $karyawan)
                <option value="{{ $karyawan->id_karyawan }}" data-position="{{ $karyawan->position }}" {{ old('id_karyawan') == $karyawan->id_karyawan ? 'selected' : '' }}>
                    {{ $karyawan->nama_karyawan }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="bulan">Bulan</label>
            <input type="month" name="bulan" id="bulan" class="form-control" value="{{ old('bulan') }}" required>
        </div>
        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" value="{{ old('gaji_pokok') }}" readonly>
        </div>
        <div class="form-group">
            <label for="uang_transport">Uang Transport</label>
            <input type="number" name="uang_transport" id="uang_transport" class="form-control" value="{{ old('uang_transport') }}" readonly>
        </div>
        <div class="form-group">
            <label for="uang_makan">Uang Makan</label>
            <input type="number" name="uang_makan" id="uang_makan" class="form-control" value="{{ old('uang_makan') }}" readonly>
        </div>
        <div class="form-group">
            <label for="total_gaji">Total Gaji</label>
            <input type="number" name="total_gaji" id="total_gaji" class="form-control" value="{{ old('total_gaji') }}" readonly>
        </div>
        <!-- Input fields lainnya tidak perlu otomatis dan tetap diisi manual -->
        <div class="form-group">
            <label for="total_lembur">Total Lembur</label>
            <input type="number" name="total_lembur" id="total_lembur" class="form-control" value="{{ old('total_lembur') }}">
        </div>
        <div class="form-group">
            <label for="bonus_lembur">Bonus Lembur</label>
            <input type="number" name="bonus_lembur" id="bonus_lembur" class="form-control" value="{{ old('bonus_lembur') }}">
        </div>
        <div class="form-group">
            <label for="denda">Denda</label>
            <input type="number" name="denda" id="denda" class="form-control" value="{{ old('denda') }}">
        </div>
        <div class="form-group">
            <label for="status_pengambilan">Status Pengambilan</label>
            <select name="status_pengambilan" id="status_pengambilan" class="form-control">
                <option value="0" {{ old('status_pengambilan') == '0' ? 'selected' : '' }}>Belum Diambil</option>
                <option value="1" {{ old('status_pengambilan') == '1' ? 'selected' : '' }}>Sudah Diambil</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const karyawanSelect = document.getElementById('id_karyawan');
    const gajiPokokInput = document.getElementById('gaji_pokok');
    const uangTransportInput = document.getElementById('uang_transport');
    const uangMakanInput = document.getElementById('uang_makan');
    const totalGajiInput = document.getElementById('total_gaji');

    karyawanSelect.addEventListener('change', function() {
        const selectedOption = karyawanSelect.options[karyawanSelect.selectedIndex];
        const position = selectedOption.getAttribute('data-position');

        let gajiPokok = 0;
        let uangTransport = 350000; // default uang transport
        let uangMakan = 300000; // default uang makan

        console.log("Selected Position: ", position); // Debugging: cek posisi yang terpilih

        switch (posisi) {
            case 'Karyawan Administrasi':
                gajiPokok = 3000000;
                break;
            case 'Sopir':
                gajiPokok = 2500000;
                break;
            case 'Supervisor Produksi':
                gajiPokok = 3000000;
                break;
            case 'Manager Produksi':
                gajiPokok = 4000000;
                break;
            case 'Karyawan Quality Control':
                gajiPokok = 4500000;
                break;
            default:
                gajiPokok = 0; // Set default jika posisi tidak diketahui
                uangTransport = 0;
                uangMakan = 0;
                console.log("Posisi tidak ditemukan! Menggunakan nilai default.");
                break;
        }

        // Mengisi input field dengan nilai yang dihitung
        gajiPokokInput.value = gajiPokok;
        uangTransportInput.value = uangTransport;
        uangMakanInput.value = uangMakan;
        totalGajiInput.value = gajiPokok + uangTransport + uangMakan;

        console.log("Gaji Pokok: ", gajiPokok); // Debugging: cek nilai gaji pokok
        console.log("Total Gaji: ", gajiPokok + uangTransport + uangMakan); // Debugging: cek nilai total gaji
    });
});
</script>
@endsection
