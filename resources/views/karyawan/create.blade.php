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
                                <label for="jenis_karyawan">Jenis Karyawan</label>
                                <select class="form-control @error('jenis_karyawan') is-invalid @enderror" id="jenis_karyawan" name="jenis_karyawan" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Harian" @if(old('jenis_karyawan') == 'Harian') selected @endif>Harian</option>
                                    <option value="Borongan" @if(old('jenis_karyawan') == 'Borongan') selected @endif>Borongan</option>
                                    <option value="Tetap" @if(old('jenis_karyawan') == 'Tetap') selected @endif>Tetap</option>
                                </select>
                                @error('jenis_karyawan')
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
                                <label for="posisi">Posisi</label>
                                <input type="text" class="form-control @error('posisi') is-invalid @enderror" id="posisi" name="posisi" value="{{ old('posisi') }}" required>
                                @error('posisi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
