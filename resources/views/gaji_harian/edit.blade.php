@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Gaji Harian</h1>
    <form action="{{ route('gaji_harian.update', $gaji_harian->id_gaji_harian) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_karyawan">Nama Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control">
                @foreach($karyawan as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}" {{ $gaji_harian->id_karyawan == $karyawan->id_karyawan ? 'selected' : '' }}>{{ $karyawan->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $gaji_harian->tanggal }}">
        </div>
        <div class="form-group">
            <label for="id_pekerjaan">Jenis Pekerjaan</label>
            <select name="id_pekerjaan" id="id_pekerjaan" class="form-control">
                @foreach($pekerjaan as $pekerjaan)
                    <option value="{{ $pekerjaan->id }}" {{ $gaji_harian->id_pekerjaan == $pekerjaan->id_pekerjaan ? 'selected' : '' }}>{{ $pekerjaan->nama_pekerjaan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="jumlah_pekerjaan">Jumlah Pekerjaan</label>
            <input type="number" name="jumlah_pekerjaan" id="jumlah_pekerjaan" class="form-control" value="{{ $gaji_harian->jumlah_pekerjaan }}">
        </div>
        <div class="form-group">
            <label for="target_harian">Target Harian</label>
            <input type="number" name="target_harian" id="target_harian" class="form-control" value="{{ $gaji_harian->target_harian }}">
        </div>
        <div class="form-group">
            <label for="capaian_harian">Capaian Harian</label>
            <input type="number" name="capaian_harian" id="capaian_harian" class="form-control" value="{{ $gaji_harian->capaian_harian }}">
        </div>
        <div class="form-group">
            <label for="status_pengambilan">Status Pengambilan</label>
            <select name="status_pengambilan" id="status_pengambilan" class="form-control">
                <option value="0" {{ $gaji_harian->status_pengambilan == 0 ? 'selected' : '' }}>Belum Diambil</option>
                <option value="1" {{ $gaji_harian->status_pengambilan == 1 ? 'selected' : '' }}>Diambil</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
