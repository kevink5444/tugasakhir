@extends('layouts.app')

@section('content')
    <h1>Edit Gaji Borongan</h1>
    <form action="{{ route('gaji_borongan.update', $gaji_borongan->id_gaji_borongan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control">
                @foreach($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}" {{ $gaji_borongan->id_karyawan == $k->id_karyawan ? 'selected' : '' }}>{{ $k->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $gaji_borongan->tanggal }}" required>
        </div>
        <div class="form-group">
            <label for="pekerjaan">Pekerjaan</label>
            <select name="pekerjaan" id="pekerjaan" class="form-control">
                <option value="kancing" {{ $gaji_borongan->pekerjaan == 'kancing' ? 'selected' : '' }}>Kancing</option>
                <option value="lubang" {{ $gaji_borongan->pekerjaan == 'lubang' ? 'selected' : '' }}>Lubang</option>
                <option value="obras_baju" {{ $gaji_borongan->pekerjaan == 'obras_baju' ? 'selected' : '' }}>Obras Baju</option>
                <option value="obras_tangan" {{ $gaji_borongan->pekerjaan == 'obras_tangan' ? 'selected' : '' }}>Obras Tangan</option>
                <option value="obras_lengan" {{ $gaji_borongan->pekerjaan == 'obras_lengan' ? 'selected' : '' }}>Obras Lengan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="jumlah_pekerjaan">Jumlah Pekerjaan</label>
            <input type="number" name="jumlah_pekerjaan" id="jumlah_pekerjaan" class="form-control" value="{{ $gaji_borongan->jumlah_pekerjaan }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
