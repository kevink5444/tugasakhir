@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="my-4 text-center">Edit Penggajian</h1>
    <form action="{{ route('penggajian.update', $penggajian->id_penggajian) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select name="id_karyawan" class="form-control" required>
                <option value="">Pilih Karyawan</option>
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}" {{ $penggajian->id_karyawan == $karyawan->id_karyawan ? 'selected' : '' }}>{{ $karyawan->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" class="form-control" value="{{ $penggajian->gaji_pokok }}" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection