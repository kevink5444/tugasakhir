
@extends('layout')

@section('content')
    <h2>Tambah Penggajian</h2>
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
        <button type="submit">Simpan</button>
    </form>
@endsection
