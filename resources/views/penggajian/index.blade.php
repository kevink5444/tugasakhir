@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 20px;">
        <h2>Daftar Penggajian</h2>
        <a href="{{ route('penggajian.create') }}" class="btn btn-primary">Tambah Penggajian</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Penggajian</th>
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
                        <td>{{ $item->potongan }}</td> <!-- Kolom potongan -->
                        <td>{{ $item->total_gaji }}</td>
                        <td>
                            <a href="{{ route('penggajian.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('penggajian.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
