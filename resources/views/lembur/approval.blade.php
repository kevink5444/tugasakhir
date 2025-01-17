@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Persetujuan Lembur</h1>
    
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Lembur</th>
                <th>Nama Karyawan</th>
                <th>Tanggal Lembur</th>
                <th>Jam Lembur</th>
                <th>Status Lembur</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lemburPending as $item)
                <tr>
                    <td>{{ $item->id_lembur }}</td>
                    <td>{{ $item->karyawan->nama_karyawan }}</td>
                    <td>{{ $item->tanggal_lembur }}</td>
                    <td>{{ $item->jam_lembur }}</td>
                    <td><span class="badge bg-warning">{{ $item->status_lembur }}</span></td>
                    <td>
                        <form action="{{ route('lembur.approve', $item->id_lembur) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_lembur" value="Disetujui">
                            <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                        </form>
                        <form action="{{ route('lembur.approve', $item->id_lembur) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_lembur" value="Ditolak">
                            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $lemburPending->links() }}
</div>
@endsection
