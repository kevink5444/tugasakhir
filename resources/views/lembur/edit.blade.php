@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pengajuan Lembur</h1>

    <form action="{{ route('lembur.update', $lembur->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="status_lembur">Status Lembur</label>
            <select id="status_lembur" name="status_lembur" class="form-control">
                <option value="pending" {{ $lembur->status_lembur == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $lembur->status_lembur == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ $lembur->status_lembur == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
