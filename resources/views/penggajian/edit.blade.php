@extends('layouts.app')

@section('content')
    <form action="{{ route('penggajian.update', $penggajian->id_penggajian) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" class="form-control" value="{{ $penggajian->gaji_pokok }}" required>
        </div>
        <div class="form-group">
            <label for="bonus">Bonus</label>
            <input type="number" name="bonus" class="form-control" value="{{ $penggajian->bonus }}">
        </div>
        <div class="form-group">
            <label for="denda">Denda</label>
            <input type="number" name="denda" class="form-control" value="{{ $penggajian->denda }}">
        </div>
        <div class="form-group">
            <label for="total_gaji">Total Gaji</label>
            <input type="number" name="total_gaji" class="form-control" value="{{ $penggajian->total_gaji }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
