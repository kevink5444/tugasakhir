@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Gaji Borongan</h1>
    <form action="{{ route('gaji_borongan.update', $gaji_borongan->id_gaji_borongan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_karyawan">Nama Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control">
                @foreach($karyawan as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}" {{ $karyawan->id == $gaji_borongan->id_karyawan ? 'selected' : '' }}>{{ $karyawan->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="minggu_mulai">Minggu Mulai</label>
            <input type="date" name="minggu_mulai" id="minggu_mulai" class="form-control" value="{{ $gaji_borongan->minggu_mulai }}">
        </div>
        <div class="form-group">
            <label for="minggu_selesai">Minggu Selesai</label>
            <input type="date" name="minggu_selesai" id="minggu_selesai" class="form-control" value="{{ $gaji_borongan->minggu_selesai }}">
        </div>
        <div class="form-group">
            <label for="total_pekerjaan">Total Pekerjaan</label>
            <input type="number" name="total_pekerjaan[{{ $gaji_borongan->pekerjaan }}]" id="total_pekerjaan" class="form-control" value="{{ $total_pekerjaan[$gaji_borongan->pekerjaan] ?? '' }}">
        </div>
        <div class="form-group">
            <label for="total_lembur">Total Lembur</label>
            <input type="number" name="total_lembur" id="total_lembur" class="form-control" value="{{ $gaji_borongan->total_lembur }}">
        </div>
        <div class="form-group">
            <label for="bonus_lembur">Bonus Lembur</label>
            <input type="number" name="bonus_lembur" id="bonus_lembur" class="form-control" value="{{ $gaji_borongan->bonus_lembur }}">
        </div>
        <div class="form-group">
            <label for="status_pengambilan">Status Pengambilan</label>
            <select name="status_pengambilan" id="status_pengambilan" class="form-control">
                <option value="0" {{ !$gaji_borongan->status_pengambilan ? 'selected' : '' }}>Belum Diambil</option>
                <option value="1" {{ $gaji_borongan->status_pengambilan ? 'selected' : '' }}>Sudah Diambil</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection