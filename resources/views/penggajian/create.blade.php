
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
            <label for="gaji_pokok">Gaji Pokok:</label>
            <input type="number" id="Gaji Pokok" name="Gaji Pokok" step="0.01" required>
        </div>
        <div>
            <label for="bonus">Bonus:</label>
            <input type="number" id="bonus" name="bonus" step="0.01" required>
        </div>
        <div>
            <label for="denda">Potongan:</label>
            <input type="number" id="denda" name="denda" step="0.01" required>
        </div>
        <div>
            <label for="Total Gaji">Total Gaji:</label>
            <input type="number" id="Total Gaji" name="Total Gaji" step="0.01" required>
        </div>
        <button type="submit">Simpan</button>
    </form>
@endsection
