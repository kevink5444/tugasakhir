@extends('layouts.app')

@section('content')
<h1 class="my-4 text-center">Edit Karyawan</h1>
    <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_karyawan">ID Karyawan</label>
            <input type="text" id="id_karyawan" name="id_karyawan" class="form-control" value="{{ old('id_karyawan', $karyawan->id_karyawan) }}" readonly>
        </div>
        <div class="form-group">
            <label for="nama_karyawan">Nama Karyawan</label>
            <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control"value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email_karyawan" class="form-control" value="{{ old('email_karyawan', $karyawan->email_karyawan) }}" readonly>
        </div>        
        <div class="form-group">
            <label for="alamat_karyawan">Alamat Karyawan</label>
            <input type="text" id="alamat_karyawan" name="alamat_karyawan" class="form-control" value="{{ old('alamat_karyawan', $karyawan->alamat_karyawan) }}" required>
        </div>
        <div class="form-group">
            <label for="jenis_karyawan">Status Karyawan</label>
            <select id="jenis_karyawan" name="jenis_karyawan" class="form-control" required>
                <option value="">Pilih Status Karyawan</option>
                @foreach($jenis as $key => $value)
                    <option value="{{ $key }}" {{ $key == old('jenis_karyawan', $karyawan->jenis_karyawan) ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
