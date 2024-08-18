@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajukan Lembur</h1>

    <form action="{{ route('lembur.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select id="id_karyawan" name="id_karyawan" class="form-control" required>
                @foreach ($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}">{{ $k->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="tanggal_lembur">Tanggal Lembur</label>
            <input type="date" id="tanggal_lembur" name="tanggal_lembur" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jam_lembur">Jam Lembur</label>
            <input type="number" id="jam_lembur" name="jam_lembur" class="form-control" required min="1">
        </div>

        <div class="form-group">
            <label for="bonus_lembur">Bonus Lembur</label>
            <input type="number" id="bonus_lembur" name="bonus_lembur" class="form-control" value="0" min="0">
        </div>

        <div class="form-group">
            <label for="status_lembur">Status Lembur</label>
            <select id="status_lembur" name="status_lembur" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan</button>
    </form>
</div>
@endsection
