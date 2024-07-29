<!-- resources/views/capaian/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Capaian</h1>
    <form action="{{ route('capaian.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select id="id_karyawan" name="id_karyawan" class="form-control" required>
                <option value="">Pilih Karyawan</option>
                @foreach ($karyawan as $karyawanItem)
                    <option value="{{ $karyawanItem->id_karyawan }}">{{ $karyawanItem->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="pekerjaan">Pekerjaan</label>
            <select id="pekerjaan" name="pekerjaan_id" class="form-control" required>
                <option value="">Pilih Pekerjaan</option>
                @foreach ($pekerjaan as $pekerjaanItem)
                    <option value="{{ $pekerjaanItem->id }}">{{ $pekerjaanItem->nama_pekerjaan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="jumlah_capaian">Jumlah Capaian</label>
            <input type="number" id="jumlah_capaian" name="jumlah_capaian" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection