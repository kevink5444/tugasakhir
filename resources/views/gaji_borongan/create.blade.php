@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Gaji Borongan</h1>
    <form action="{{ route('gaji_borongan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_karyawan">Nama Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control">
                @foreach($karyawan as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="minggu_mulai">Minggu Mulai</label>
            <input type="date" name="minggu_mulai" id="minggu_mulai" class="form-control">
        </div>
        <div class="form-group">
            <label for="minggu_selesai">Minggu Selesai</label>
            <input type="date" name="minggu_selesai" id="minggu_selesai" class="form-control">
        </div>
        <div class="form-group">
            <label for="total_pekerjaan">Total Pekerjaan</label>
            <input type="number" name="total_pekerjaan[kancing]" class="form-control" placeholder="Kancing">
            <input type="number" name="total_pekerjaan[lubang]" class="form-control" placeholder="Lubang">
            <input type="number" name="total_pekerjaan[obras_baju]" class="form-control" placeholder="Obras Baju">
            <input type="number" name="total_pekerjaan[obras_tangan]" class="form-control" placeholder="Obras Tangan">
            <input type="number" name="total_pekerjaan[obras_lengan]" class="form-control" placeholder="Obras Lengan">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
