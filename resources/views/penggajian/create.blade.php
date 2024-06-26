
@extends('layout')
@section('title', 'Tambah Penggajian')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="my-4 text-center">Tambah Penggajian</h2>
    <form action="{{ route('penggajian.store') }}" method="POST">
        @csrf
        <div>
            <label for="id_karyawan">Karyawan:</label>
            <select id="id_karyawan" name="id_karyawan" required>
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="number" id="gaji_pokok" name="gaji_pokok" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
@endsection
