@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Pengajuan Lembur</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ID: {{ $lembur->id }}</h5>
            <p class="card-text">Nama Karyawan: {{ $lembur->karyawan->nama }}</p>
            <p class="card-text">Tanggal Lembur: {{ $lembur->tanggal_lembur }}</p>
            <p class="card-text">Status: {{ $lembur->status_lembur }}</p>
            <p class="card-text">Bonus Lembur: {{ $lembur->bonus_lembur }}</p>
            <a href="{{ route('lembur.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
</div>
@endsection
