@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="my-4 text-center">{{ isset($pengaturan) ? 'Edit' : 'Tambah' }} Pengaturan Target</h1>
    <form action="{{ isset($pengaturan) ? route('pengaturan_target.update', $pengaturan->id_pengaturan) : route('pengaturan_target.store') }}" method="POST">
        @csrf
        @if(isset($pengaturan))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="id_pekerjaan">Pekerjaan</label>
            <select name="id_pekerjaan" class="form-control" required>
                <option value="">Pilih Pekerjaan</option>
                @foreach ($pekerjaans as $pekerjaan)
                    <option value="{{ $pekerjaan->id_pekerjaan }}" {{ isset($pengaturan) && $pengaturan->id_pekerjaan == $pekerjaan->id_pekerjaan ? 'selected' : '' }}>{{ $pekerjaan->nama_pekerjaan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="target_borongan">Target Borongan</label>
            <input type="number" class="form-control" id="target_borongan" name="target_borongan" required>
        <div class="form-group">
            <label for="target_mingguan">Target Mingguan</label>
            <input type="number" name="target_mingguan" class="form-control" value="{{ isset($pengaturan) ? $pengaturan->target_mingguan : '' }}" required>
        </div>
        <div class="form-group">
            <label for="potongan_per_unit">Potongan Per Unit</label>
            <input type="number" name="potongan_per_unit" class="form-control" value="{{ isset($pengaturan) ? $pengaturan->potongan_per_unit : '' }}" required>
        </div>
        <button type="submit" class="btn btn-success">{{ isset($pengaturan) ? 'Update' : 'Simpan' }}</button>
    </form>
</div>
@endsection