@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Gaji Bulanan</h2>

    <form action="{{ route('gaji_bulanan.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="id_karyawan">Pilih Karyawan</label>
            <select id="id_karyawan" name="id_karyawan" class="form-control" required>
                <option value="">-- Pilih Karyawan --</option>
                @foreach ($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}">{{ $k->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="bulan">Pilih Bulan</label>
            <input type="month" id="bulan" name="bulan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="text" id="gaji_pokok" name="gaji_pokok" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="uang_transport">Uang Transport</label>
            <input type="text" id="uang_transport" name="uang_transport" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="uang_makan">Uang Makan</label>
            <input type="text" id="uang_makan" name="uang_makan" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="bonus">Bonus</label>
            <input type="text" id="bonus" name="bonus" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="denda">Denda</label>
            <input type="text" id="denda" name="denda" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="bonus_lembur">Bonus Lembur</label>
            <input type="text" id="bonus_lembur" name="bonus_lembur" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="total_gaji_bulanan">Total Gaji Bulanan</label>
            <input type="text" id="total_gaji_bulanan" name="total_gaji_bulanan" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

{{-- Script AJAX untuk otomatis mengisi data --}}
<script>
    document.getElementById('id_karyawan').addEventListener('change', function() {
        var idKaryawan = this.value;
        var bulan = document.getElementById('bulan').value;

        if (idKaryawan && bulan) {
            fetch(`/gaji-karyawan/${idKaryawan}/${bulan}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('gaji_pokok').value = data.gaji_pokok;
                    document.getElementById('uang_transport').value = data.uang_transport;
                    document.getElementById('uang_makan').value = data.uang_makan;
                    document.getElementById('bonus').value = data.bonus;
                    document.getElementById('denda').value = data.denda;
                    document.getElementById('bonus_lembur').value = data.bonus_lembur;
                    document.getElementById('total_gaji_bulanan').value = data.total_gaji_bulanan;
                });
        }
    });

    document.getElementById('bulan').addEventListener('change', function() {
        document.getElementById('id_karyawan').dispatchEvent(new Event('change'));
    });
</script>
@endsection
