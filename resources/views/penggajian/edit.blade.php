@extends('layout')

@section('content')
    <h2>Edit Penggajian</h2>
    <form action="{{ route('gaji.update', $gaji->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="id_karyawan">Karyawan:</label>
            <select id="id_karyawan" name="id_karyawan" required>
                @foreach ($karyawan as $emp)
                    <option value="{{ $emp->id }}" {{ $emp->id == $gaji->id_karyawan ? 'selected' : '' }}>{{ $emp->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="gaji_pokok">Gaji Pokok:</label>
            <input type="number" id="gaji_pokok" name="gaji_pokok" step="0.01" value="{{ $gaji->gaji_pokok }}" required>
        </div>
        <div>
            <label for="bonus">Bonus:</label>
            <input type="number" id="bonus" name="bonus" step="0.01" value="{{ $gaji->bonus }}" required>
        </div>
        <div>
            <label for="denda">Potongan:</label>
            <input type="number" id="denda" name="denda" step="0.01" value="{{ $gaji->denda }}" required>
        </div>
        <div>
            <label for="total_gaji">Total Gaji:</label>
            <input type="number" id="total_gaji" name="total_gaji" step="0.01" value="{{ $gaji->total_gaji }}" required>
        </div>
        <button type="submit">Simpan</button>
    </form>
@endsection
