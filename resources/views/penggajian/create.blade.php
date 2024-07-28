@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="my-4 text-center">Tambah Penggajian</h1>
    <form action="{{ route('penggajian.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select name="id_karyawan" class="form-control" required>
                <option value="">Pilih Karyawan</option>
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="capaian">Capaian</label>
            <input type="number" name="capaian" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection