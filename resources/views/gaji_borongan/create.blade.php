@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Gaji Borongan</h1>

    <form action="{{ route('gajiBorongan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_karyawan" class="form-label">Nama Karyawan</label>
            <select class="form-select" id="id_karyawan" name="id_karyawan" required>
                <option value="">Pilih Karyawan</option>
                @foreach($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}">{{ $k->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="minggu_mulai" class="form-label">Minggu Mulai</label>
            <input type="date" class="form-control" id="minggu_mulai" name="minggu_mulai" required>
        </div>

        <div class="mb-3">
            <label for="minggu_selesai" class="form-label">Minggu Selesai</label>
            <input type="date" class="form-control" id="minggu_selesai" name="minggu_selesai" required>
        </div>

        <div class="mb-3">
            <label for="capaian_harian" class="form-label">Capaian Harian (Otomatis)</label>
            <input type="number" class="form-control" id="capaian_harian" name="capaian_harian" readonly>
        </div>

        <div class="mb-3">
            <label for="total_lembur" class="form-label">Total Lembur (Jam)</label>
            <input type="number" class="form-control" id="total_lembur" name="total_lembur" required>
        </div>

        <div class="mb-3">
            <label for="bonus_lembur" class="form-label">Bonus Lembur (Otomatis)</label>
            <input type="number" class="form-control" id="bonus_lembur" name="bonus_lembur" readonly>
        </div>

        <div class="mb-3">
            <label for="total_bonus" class="form-label">Total Bonus (Otomatis)</label>
            <input type="number" class="form-control" id="total_bonus" name="total_bonus" readonly>
        </div>

        <div class="mb-3">
            <label for="total_denda" class="form-label">Total Denda (Otomatis)</label>
            <input type="number" class="form-control" id="total_denda" name="total_denda" readonly>
        </div>

        <div class="mb-3">
            <label for="total_gaji_borongan" class="form-label">Total Gaji Borongan (Otomatis)</label>
            <input type="number" class="form-control" id="total_gaji_borongan" name="total_gaji_borongan" readonly>
        </div>

        <div class="mb-3">
            <label for="status_pengambilan" class="form-label">Status Pengambilan</label>
            <input type="text" class="form-control" id="status_pengambilan" name="status_pengambilan" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Gaji Borongan</button>
    </form>
</div>
@endsection
