<!-- resources/views/karyawan/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tambah Karyawan</div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('karyawan.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="nama_karyawan">Nama Karyawan</label>
                                <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror" id="nama_karyawan" name="nama_karyawan" value="{{ old('nama_karyawan') }}" required>
                                @error('nama_karyawan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="alamat_karyawan">Alamat Karyawan</label>
                                <textarea class="form-control @error('alamat_karyawan') is-invalid @enderror" id="alamat_karyawan" name="alamat_karyawan" required>{{ old('alamat_karyawan') }}</textarea>
                                @error('alamat_karyawan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email Karyawan</label>
                                <input type="email" class="form-control @error('email_karyawan') is-invalid @enderror" id="email_karyawan" name="email_karyawan" value="{{ old('email_karyawan') }}" required>
                                @error('email_karyawan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status_karyawan">Status Karyawan</label>
                                <select class="form-control @error('status_karyawan') is-invalid @enderror" id="status_karyawan" name="status_karyawan" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Borongan" @if(old('status_karyawan') == 'Borongan') selected @endif>Borongan</option>
                                    <option value="Harian" @if(old('status_karyawan') == 'Harian') selected @endif>Harian</option>
                                    <option value="Tetap" @if(old('status_karyawan') == 'Tetap') selected @endif>Tetap</option>
                                </select>
                                @error('status_karyawan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $karyawan->pekerjaan ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="target_borongan">Target Borongan</label>
                                <input type="number" class="form-control" id="target_borongan" name="target_borongan" required>
                            </div>
                            <div class="form-group">
                                <label for="target_harian">Target Harian</label>
                                <input type="number" class="form-control" id="target_harian" name="target_harian" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
