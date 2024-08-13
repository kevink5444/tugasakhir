@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Gaji Harian</h1>
    <form action="{{ route('gaji_harian.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_karyawan">Nama Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control">
                @foreach($karyawan as $karyawanItem)
                    <option value="{{ $karyawanItem->id_karyawan }}" {{ old('id_karyawan') == $karyawanItem->id_karyawan ? 'selected' : '' }}>
                        {{ $karyawanItem->nama_karyawan }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}">
        </div>
        <div class="form-group">
            <label for="jenis_pekerjaan">Jenis Pekerjaan</label>
        <select name="id_pekerjaan" id="id_pekerjaan" class="form-control">
            @foreach($pekerjaan as $pekerjaan)
                <option value="{{ $pekerjaan->id_pekerjaan }}" {{ old('id_pekerjaan') == $pekerjaan->id_pekerjaan ? 'selected' : '' }}>{{ $pekerjaan->nama_pekerjaan }}</option>
            @endforeach
        </select>
        <div class="form-group">
            <label for="jumlah_pekerjaan">Jumlah Pekerjaan</label>
            <input type="number" name="jumlah_pekerjaan" id="jumlah_pekerjaan" class="form-control" value="{{ old('jumlah_pekerjaan') }}">
        </div>
        <div class="form-group">
            <label for="target_harian">Target Harian</label>
            <input type="number" name="target_harian" id="target_harian" class="form-control" value="{{ old('target_harian') }}">
        </div>
        <div class="form-group">
            <label for="capaian_harian">Capaian Harian</label>
            <input type="number" name="capaian_harian" id="capaian_harian" class="form-control" value="{{ old('capaian_harian') }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
