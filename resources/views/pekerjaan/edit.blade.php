@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="my-4 text-center">{{ isset($pekerjaan) ? 'Edit' : 'Tambah' }} Pekerjaan</h1>
    <form action="{{ isset($pekerjaan) ? route('pekerjaan.update', $pekerjaan->id_pekerjaan) : route('pekerjaan.store') }}" method="POST">
        @csrf
        @if(isset($pekerjaan))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="nama_pekerjaan">Nama Pekerjaan</label>
            <input type="text" name="nama_pekerjaan" class="form-control" value="{{ isset($pekerjaan) ? $pekerjaan->nama_pekerjaan : '' }}" required>
        </div>
        <div class="form-group">
            <label for="target_harian">Target Harian</label>
            <input type="number" name="target_harian" class="form-control" value="{{ isset($pekerjaan) ? $pekerjaan->target_harian : '' }}" required>
        </div>
        <div class="form-group">
            <label for="harga_per_unit">Harga per Unit:</label>
            <input type="number" step="0.01" name="harga_per_unit" id="harga_per_unit" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">{{ isset($pekerjaan) ? 'Update' : 'Simpan' }}</button>
    </form>
</div>
@endsection