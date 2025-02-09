@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Absensi</h2>
    <form action="{{ route('absensi.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                @foreach($karyawan as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}">
                        {{ $karyawan->nama_karyawan }} - {{ $karyawan->jenis_karyawan }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required onchange="toggleWaktuMasuk()">
                <option value="masuk">Masuk</option>
                <option value="terlambat">Terlambat</option>
                <option value="tidakmasuk">Tidak Masuk</option>
            </select>
        </div>
        <div class="form-group">
            <label for="waktu_masuk">Waktu Masuk</label>
            <input type="datetime-local" name="waktu_masuk" id="waktu_masuk" class="form-control">
        </div>
        <div class="form-group">
            <label for="waktu_pulang">Waktu Pulang</label>
            <input type="datetime-local" name="waktu_pulang" id="waktu_pulang" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
<script>
    function toggleWaktuMasuk() {
        let status = document.getElementById('status').value;
        let waktuMasuk = document.getElementById('waktu_masuk');
        let waktuPulang = document.getElementById('waktu_pulang');
    
        if (status === 'tidakmasuk') {
            waktuMasuk.disabled = true;
            waktuMasuk.value = '';
            waktuPulang.disabled = true;
            waktuPulang.value = '';
        } else {
            waktuMasuk.disabled = false;
            waktuPulang.disabled = false;
        }
    }
    </script>
