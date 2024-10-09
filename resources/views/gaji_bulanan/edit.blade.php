@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">{{ isset($gajiBulanan) ? 'Edit Gaji Bulanan' : 'Tambah Gaji Bulanan' }}</h1>
    
    <form action="{{ isset($gajiBulanan) ? route('gaji_bulanan.update', $gajiBulanan->id_gaji_bulanan) : route('gaji_bulanan.store') }}" method="POST">
        @csrf
        @if(isset($gajiBulanan))
            @method('PUT')
        @endif
        
        <div class="form-group">
            <label for="id_karyawan">Nama Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control">
                @foreach($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}" {{ isset($gajiBulanan) && $gajiBulanan->id_karyawan == $karyawan->id_karyawan ? 'selected' : '' }}>
                        {{ $karyawan->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="bulan">Bulan</label>
            <input type="month" name="bulan" id="bulan" class="form-control" value="{{ isset($gajiBulanan) ? \Carbon\Carbon::parse($gajiBulanan->bulan)->format('Y-m') : '' }}" required>
        </div>

        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" value="{{ isset($gajiBulanan) ? $gajiBulanan->gaji_pokok : '' }}" readonly>
        </div>
        
        <div class="form-group">
            <label for="uang_transport">Uang Transport</label>
            <input type="number" name="uang_transport" id="uang_transport" class="form-control" value="{{ isset($gajiBulanan) ? $gajiBulanan->uang_transport : '350000' }}" readonly>
        </div>
        
        <div class="form-group">
            <label for="uang_makan">Uang Makan</label>
            <input type="number" name="uang_makan" id="uang_makan" class="form-control" value="{{ isset($gajiBulanan) ? $gajiBulanan->uang_makan : '300000' }}" readonly>
        </div>
        
        <button type="submit" class="btn btn-primary">{{ isset($gajiBulanan) ? 'Update' : 'Simpan' }}</button>
    </form>
</div>
@endsection

<script>
document.getElementById('id_karyawan').addEventListener('change', function() {
    var selectedKaryawan = this.options[this.selectedIndex];
    var posisi = selectedKaryawan.getAttribute('data-posisi');
    var gajiPokok = 0;

    // Tentukan gaji pokok berdasarkan posisi
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
            gajiPokok = 0;
    }

    document.getElementById('gaji_pokok').value = gajiPokok;
});
</script>