@extends('layouts.app')

@section('title', 'Tambah Penggajian')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                </h5>
                <div class="card-body">
                    <form action="{{ route('penggajian.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="id_karyawan">Pilih Karyawan:</label>
                            <select id="id_karyawan" name="id_karyawan" class="form-control" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama_karyawan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gaji_pokok">Gaji Pokok (IDR):</label>
                            <input type="number" id="gaji_pokok" name="gaji_pokok" step="0.01" class="form-control" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Tambah Penggajian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
