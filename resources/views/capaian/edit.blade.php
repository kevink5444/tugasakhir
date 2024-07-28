@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="my-4 text-center">{{ isset($capaian) ? 'Edit' : 'Tambah' }} Capaian</h1>
    <form action="{{ isset($capaian) ? route('capaian.update', $capaian->id_capaian) : route('capaian.store') }}" method="POST">
        @csrf
        @if(isset($capaian))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select name="id_karyawan" class="form-control" required>
                <option value="">Pilih Karyawan</option>
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}" {{ isset($capaian) && $capaian->id_karyawan == $karyawan->id_karyawan ? 'selected' : '' }}>{{ $karyawan->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="id_pekerjaan">Pekerjaan</label>
            <select name="id_pekerjaan" class="form-control" required>
                <option value="">Pilih Pekerjaan</option>
                @foreach ($pekerjaans as $pekerjaan)
                    <option value="{{ $pekerjaan->id_pekerjaan }}" {{ isset($capaian) && $capaian->id_pekerjaan == $pekerjaan->id_pekerjaan ? 'selected' : '' }}>{{ $pekerjaan->nama_pekerjaan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ isset($capaian) ? $capaian->tanggal : '' }}" required>
        </div>
        <div class="form-group">
            <label for="jumlah_capaian">Jumlah Capaian</label>
            <input type="number" name="jumlah_capaian" class="form-control" value="{{ isset($capaian) ? $capaian->jumlah_capaian : '' }}" required>
        </div>
        <div class="form-group">
            <label for="pekerjaan">Pekerjaan</label>
            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $karyawan->pekerjaan ?? '') }}">
        </div>
        
        <div class="form-group">
            <label for="target_mingguan">Target Mingguan</label>
            <input type="number" class="form-control" id="target_mingguan" name="target_mingguan" value="{{ old('target_mingguan', $karyawan->target_mingguan ?? 0) }}">
        </div>
        <div class="form-group">
            <label for="target_borongan">Target Borongan</label>
            <input type="number" class="form-control" id="target_borongan" name="target_borongan" value="{{ old('target_borongan', $karyawan->target_borongan ?? 0) }}">
        </div>
        
        <div class="form-group">
            <label for="target_harian">Target Harian</label>
            <input type="number" class="form-control" id="target_harian" name="target_harian" value="{{ old('target_harian', $karyawan->target_harian ?? 0) }}">
        </div>
        <button type="submit" class="btn btn-success">{{ isset($capaian) ? 'Update' : 'Simpan' }}</button>
    </form>
</div>
@endsection