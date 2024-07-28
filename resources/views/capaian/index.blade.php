@extends('layouts.app')
@section('content')
<a href="{{ route('capaian.create') }}" class="btn btn-primary">Tambah Capaian</a>
<div class="container">
    <h1 class="my-4 text-center">Data Capaian</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Capaian</th>
                    <th>Karyawan</th>
                    <th>Pekerjaan</th>
                    <th>Tanggal</th>
                    <th>Jumlah Capaian</th>
                    <th>Tombol</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($capaian as $capaian)
                    <tr>
                        <td>{{ $capaian->id_capaian }}</td>
                        <td>{{ $capaian->karyawan->nama_karyawan }}</td>
                        <td>{{ $capaian->pekerjaan->nama_pekerjaan }}</td>
                        <td>{{ $capaian->tanggal }}</td>
                        <td>{{ $capaian->jumlah_capaian }}</td>
                        <td>
                            <a href="{{ route('capaian.edit', $capaian->id_capaian) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('capaian.delete', $capaian->id_capaian) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection