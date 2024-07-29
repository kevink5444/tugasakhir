@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gaji Karyawan</h1>
    @foreach($karyawans as $karyawan)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $karyawan->nama_karyawan }}</h5>
                <p>Email: {{ $karyawan->email_karyawan }}</p>
                <p>Target Mingguan: {{ $karyawan->target_borongan }}</p>
                <a href="{{ route('penggajian.hitung', $karyawan->id_karyawan) }}" class="btn btn-primary">Hitung Gaji</a>
            </div>
        </div>
    @endforeach
</div>
@endsection