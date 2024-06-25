@extends('layouts.app')
@section('content')
<a href="{{ route('penggajian.create') }}">Tambah Penggajian</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID Penggajian</th>
                <th>ID Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Total Gaji</th>
                <th>Bonus</th>
                <th>Tombol</th>
            </tr>
        </thead>
        <tbody>
           
            @foreach ($penggajian as $penggajian)
                <tr>
                    <td>{{ $penggajian->id_penggajian }}</td>
                    <td>{{ $penggajian->id_karyawan }}</td>
                    <td>{{ $penggajian->karyawan->nama_karyawan }}</td>
                    <td>{{ $penggajian->total_gaji }}</td>
                    <td>{{ $penggajian->bonus }}</td>
                    <td>
                        <a href="{{ route('penggajian.edit', $penggajian->id_penggajian) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('penggajian.delete', $penggajian->id_penggajian) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
