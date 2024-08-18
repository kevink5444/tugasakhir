@extends('layouts.app')

@section('content')
    <h1>Tambah Gaji Borongan</h1>
    <form action="{{ route('gaji_borongan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control">
                @foreach($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}">{{ $k->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="pekerjaan">Pekerjaan</label>
            <select name="pekerjaan" id="pekerjaan" class="form-control">
                <option value="kancing">Kancing</option>
                <option value="lubang">Lubang</option>
                <option value="obras_baju">Obras Baju</option>
                <option value="obras_tangan">Obras Tangan</option>
                <option value="obras_lengan">Obras Lengan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="jumlah_pekerjaan">Jumlah Pekerjaan</label>
            <input type="number" name="jumlah_pekerjaan" id="jumlah_pekerjaan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection