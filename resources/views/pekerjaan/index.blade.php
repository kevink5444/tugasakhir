@extends('layouts.app')
@section('content')
<a href="{{ route('pekerjaan.create') }}" class="btn btn-primary">Tambah Pekerjaan</a>
<div class="container">
    <h1 class="my-4 text-center">Data Pekerjaan</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Pekerjaan</th>
                    <th>Nama Pekerjaan</th>
                    <th>Target Harian</th>
                    <th>Harga per Unit</th>
                    <th>Tombol</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pekerjaan as $pekerjaan)
                    <tr>
                        <td>{{ $pekerjaan->id_pekerjaan }}</td>
                        <td>{{ $pekerjaan->nama_pekerjaan }}</td>
                        <td>{{ $pekerjaan->target_harian }}</td>
                        <td>{{ $pekerjaan->harga_per_unit }}</td>
                        <td>
                            <a href="{{ route('pekerjaan.edit', $pekerjaan->id_pekerjaan) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('pekerjaan.destroy', $pekerjaan->id_pekerjaan) }}" method="POST" style="display:inline;">
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