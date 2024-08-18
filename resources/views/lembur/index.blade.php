@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Lembur</h1>
    <a href="{{ route('lembur.ajukan') }}" class="btn btn-primary">Ajukan Lembur</a>
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
                <th>Bonus Lembur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lembur as $item)
                <tr>
                    <td>{{ $item->id_lembur }}</td>
                    <td>{{ $item->karyawan->nama_karyawan }}</td>
                    <td>{{ $item->tanggal_lembur }}</td>
                    <td>{{ $item->jam_lembur }}</td>
                    <td>
                        @if($item->status_lembur == 'Disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($item->status_lembur == 'Pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($item->bonus_lembur, 0, ',', '.') }}</td>
                    <td>
                        @if($item->status_lembur == 'pending')
                            <form action="{{ route('lembur.approve', $item->id_lembur) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary btn-sm">Setujui</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $lembur->links() }}
</div>
@endsection
