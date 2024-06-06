@extends('layout')

@section('content')
    <h2>Daftar Penggajian</h2>
    <a href="{{ route('penggajian.create') }}">Tambah Penggajian</a>
    <table>
        <thead>
            <tr>
                <th>ID Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Gaji Pokok</th>
                <th>Bonus</th>
                <th>Potongan</th>
                <th>Total Gaji</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penggajian as $item)
                <tr>
                    <td>{{ $item->id_karyawan }}</td>
                    <td>{{ $item->karyawan->nama_karyawan ?? 'Nama tidak tersedia' }}</td>
                    <td>{{ $item->gaji_pokok }}</td>
                    <td>{{ $item->bonus }}</td>
                    <td>{{ $item->denda }}</td>
                    <td>{{ $item->total_gaji }}</td>
                    <td>
                        <!-- Mengubah akses parameter untuk route edit -->
                        <a href="{{ route('penggajian.edit', $item->id) }}">Edit Penggajian</a>
                        {{-- <form action="{{ route('penggajian.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
