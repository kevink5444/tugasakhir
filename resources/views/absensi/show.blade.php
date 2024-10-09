@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Absensi</h2>
    <dl class="row">
        <dt class="col-sm-3">ID Absensi</dt>
        <dd class="col-sm-9">{{ $absensi->id_absensi }}</dd>

        <dt class="col-sm-3">Karyawan</dt>
        <dd class="col-sm-9">{{ $absensi->karyawan->nama_karyawan }} ({{ $absensi->karyawan->tipe_gaji }})</dd>

        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">{{ $absensi->status }}</dd>

        <dt class="col-sm-3">Waktu Masuk</dt>
        <dd class="col-sm-9">{{ $absensi->waktu_masuk }}</dd>

        <dt class="col-sm-3">Waktu Pulang</dt>
        <dd class="col-sm-9">{{ $absensi->waktu_pulang }}</dd>

        <dt class="col-sm-3">Bonus</dt>
        <dd class="col-sm-9">Rp {{ number_format($absensi->bonus, 2, ',', '.') }}</dd>

        <dt class="col-sm-3">Denda</dt>
        <dd class="col-sm-9">Rp {{ number_format($absensi->denda, 2, ',', '.') }}</dd>
    </dl>
    <a href="{{ route('absensi.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
