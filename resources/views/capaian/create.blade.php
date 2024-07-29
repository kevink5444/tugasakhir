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
                            <label for="id_pekerjaan">Pekerjaan</label>
                            <select id="id_pekerjaan" name="id_pekerjaan" class="form-control" required>
                                <option value="">Pilih Pekerjaan</option>
                                @foreach($pekerjaan as $pekerjaanItem)
                                    <option value="{{ $pekerjaanItem->id_pekerjaan }}">{{ $pekerjaanItem->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_capaian">Jumlah Capaian</label>
                            <input type="number" class="form-control" id="jumlah_capaian" name="jumlah_capaian" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection