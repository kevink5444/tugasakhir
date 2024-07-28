@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Tambah Pekerjaan</h1>
    <form action="{{ route('pekerjaan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_pekerjaan">Nama Pekerjaan:</label>
            <input type="text" name="nama_pekerjaan" id="nama_pekerjaan" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="target_harian">Target Harian:</label>
            <input type="number" name="target_harian" id="target_harian" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="harga_per_unit">Harga per Unit:</label>
            <input type="number" step="0.01" name="harga_per_unit" id="harga_per_unit" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection