@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Gaji Bulanan</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('gaji_bulanan.update', $gaji_bulanan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_karyawan">Nama Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control">
                @foreach($karyawans as $karyawan)
                <option value="{{ $karyawan->id_karyawan }}" {{ $gaji_harian->id_karyawan == $karyawan->id_karyawan ? 'selected' : '' }}>{{ $karyawan->nama_karyawan }}</option>
                        {{ $karyawan->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="bulan">Bulan</label>
            <input type="month" name="bulan" id="bulan" class="form-control" value="{{ $gaji_bulanan->bulan }}" required>
        </div>
        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" value="{{ $gaji_bulanan->gaji_pokok }}" required>
        </div>
        <div class="form-group">
            <label for="uang_transport">Uang Transport</label>
            <input type="number" name="uang_transport" id="uang_transport" class="form-control" value="{{ $gaji_bulanan->uang_transport }}">
        </div>
        <div class="form-group">
            <label for="uang_makan">Uang Makan</label>
            <input type="number" name="uang_makan" id="uang_makan" class="form-control" value="{{ $gaji_bulanan->uang_makan }}">
        </div>
        <div class="form-group">
            <label for="bonus">Bonus</label>
            <input type="number" name="bonus" id="bonus" class="form-control" value="{{ $gaji_bulanan->bonus }}">
        </div>
        <div class="form-group">
            <label for="thr">THR</label>
            <input type="number" name="thr" id="thr" class="form-control" value="{{ $gaji_bulanan->thr }}">
        </div>
        <div class="form-group">
            <label for="total_gaji">Total Gaji</label>
            <input type="number" name="total_gaji" id="total_gaji" class="form-control" value="{{ $gaji_bulanan->total_gaji }}" required>
        </div>
        <div class="form-group">
            <label for="total_lembur">Total Lembur</label>
            <input type="number" name="total_lembur" id="total_lembur" class="form-control" value="{{ $gaji_bulanan->total_lembur }}">
        </div>
        <div class="form-group">
            <label for="bonus_lembur">Bonus Lembur</label>
            <input type="number" name="bonus_lembur" id="bonus_lembur" class="form-control" value="{{ $gaji_bulanan->bonus_lembur }}">
        </div>
        <div class="form-group">
            <label for="denda">Denda</label>
            <input type="number" name="denda" id="denda" class="form-control" value="{{ $gaji_bulanan->denda }}">
        </div>
        <div class="form-group">
            <label for="status_pengambilan">Status Pengambilan</label>
            <select name="status_pengambilan" id="status_pengambilan" class="form-control">
                <option value="0" {{ $gaji_bulanan->status_pengambilan == 0 ? 'selected' : '' }}>Belum Diambil</option>
                <option value="1" {{ $gaji_bulanan->status_pengambilan == 1 ? 'selected' : '' }}>Sudah Diambil</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection