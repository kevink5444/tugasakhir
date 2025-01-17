@extends('layouts.app')

@section('content')
<div class="container">


    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <!-- Tabel Riwayat Pengajuan Lembur -->
    <h2 class="mt-5">Riwayat Pengajuan Lembur</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Lembur</th>
                <th>Tanggal Lembur</th>
                <th>Jam Lembur</th>
                <th>Status</th>
                <th>Bonus Lembur</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lembur as $lembur)
                <tr>
                    <td>{{ $lembur->id_lembur }}</td>
                    <td>{{ $lembur->tanggal_lembur }}</td>
                    <td>{{ $lembur->jam_lembur }}</td>
                    <td>
                        @if($lembur->status_lembur === 'Pending')
                            <span class="badge bg-warning">{{ $lembur->status_lembur }}</span>
                        @elseif($lembur->status_lembur === 'Disetujui')
                            <span class="badge bg-success">{{ $lembur->status_lembur }}</span>
                        @else
                            <span class="badge bg-danger">{{ $lembur->status_lembur }}</span>
                        @endif
                    </td>
                    <td>{{ $lembur->bonus_lembur ?? 'Menunggu Persetujuan' }}</td>
                    <td>
                        <form action="{{ route('lembur.destroy', $lembur->id_lembur) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan lembur ini?');">
                            @csrf
                            @method('DELETE')
                            <td>
                                <form action="{{ route('lembur.destroy', $lembur->id_lembur) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mb-0">Hapus</button>
                                </form>
                                <a href="{{ route('lembur.create', $lembur->id_lembur) }}" class="btn btn-primary btn-sm mb-0 ms-1">Ajukan Lembur</a>
                                <a href="{{ route('lembur.approve', $lembur->id_lembur) }}" class="btn btn-secondary btn-sm mb-0 ms-1">Persetujuan Lembur</a>
                            </td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $lembur->links() }}
</div>
@endsection
