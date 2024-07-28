@extends('layouts.app')
@section('content')
<a href="{{ route('pengaturan_target.create') }}" class="btn btn-primary">Tambah Target</a>
<div class="container">
    <h1 class="my-4 text-center">Target</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Pekerjaan</th>
                    <th>Target Harian</th>
                    <th>Target Mingguan</th>
                    <th>Potongan Per Unit</th>
                    <th>Tombol</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($targets as $target)
                    <tr>
                        <td>{{ $targets->id_pengaturan }}</td>
                        <td>{{ $targets->pekerjaan->nama_pekerjaan }}</td>
                        <td>{{ $targets->target_harian }}</td>
                        <td>{{ $targets->target_mingguan }}</td>
                        <td>{{ $targets->potongan_per_unit }}</td>
                        <td>
                            <a href="{{ route('pengaturan_target.edit', $pengaturan->id_pengaturan) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('pengaturan_target.delete', $pengaturan->id_pengaturan) }}" method="POST" style="display:inline;">
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