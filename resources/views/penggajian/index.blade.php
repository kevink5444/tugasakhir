@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Penggajian</h2>
        <ul>
            <li><a href="{{ route('penggajian.gaji_bulanan') }}">Gaji Bulanan</a></li>
            <li><a href="{{ route('penggajian.gaji_mingguan') }}">Gaji Mingguan</a></li>
        </ul>
    </div>
@endsection
