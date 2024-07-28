@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Capaian</div>
                <div class="card-body">
                    <form action="{{ route('capaian.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="id_karyawan">Karyawan</label>
                            <select class="form-control" id="id_karyawan" name="id_karyawan" required>
                                <option value="" disabled selected>Pilih Karyawan</option>
                                @foreach($karyawan as $karyawanItem)
                                    <option value="{{ $karyawanItem->id }}">{{ $karyawanItem->nama_karyawan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan_id">Pekerjaan</label>
                            <select class="form-control" id="pekerjaan_id" name="pekerjaan_id" required>
                                <option value="" disabled selected>Pilih Pekerjaan</option>
                                @foreach($pekerjaan as $pekerjaanItem)
                                    <option value="{{ $pekerjaanItem->id }}">{{ $pekerjaanItem->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_capaian">Jumlah Capaian</label>
                            <input type="number" class="form-control" id="jumlah_capaian" name="jumlah_capaian" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection