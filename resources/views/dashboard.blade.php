@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Judul Dashboard -->
    <h1 class="text-center mb-4" style="font-size: 28px; font-weight: bold;">Dashboard UMKM CV YP Sukses Makmur</h1>

    <!-- Row Pertama: Notifikasi dan Pengumuman -->
    <div class="row">
        <!-- Kotak 1: Notifikasi Penting -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header">Notifikasi Penting</div>
                <div class="card-body">
                    <ul>
                        <li>Notifikasi 1: Cuti Bersama pada tanggal 10 Juli 2024</li>
                        <li>Notifikasi 2: Pembayaran gaji bulan ini dilakukan pada tanggal 25 Juli 2024</li>
                        <li>Notifikasi 3: Update data karyawan sebelum akhir bulan</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Kotak 2: Pengumuman Perusahaan -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header">Pengumuman Perusahaan</div>
                <div class="card-body">
                    <ul>
                        <li>Pengumuman 1: Pelatihan karyawan baru dimulai pada 15 Juli 2024</li>
                        <li>Pengumuman 2: Rapat umum bulanan akan diadakan pada 20 Juli 2024</li>
                        <li>Pengumuman 3: Program kesehatan karyawan diperpanjang hingga akhir tahun</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Kotak 3: Statistik Karyawan -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header">Statistik Karyawan</div>
                <div class="card-body">
                    <ul>
                        <li>Jumlah Karyawan: 50</li>
                        <li>Pembagian Karyawan:
                            <ul>
                                <li>Karyawan Harian: 15</li>
                                <li>Karyawan Borongan: 20</li>
                                <li>Karyawan Tetap: 15</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Kotak 4: Link Cepat -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header">Link Cepat</div>
                <div class="card-body">
                    <ul>
                        <li><a href="{{ route('gaji_borongan.index') }}">Data Penggajian Borongan</a></li>
                        <li><a href="{{ route('gaji_harian.index') }}">Data Penggajian Harian</a></li>
                        <li><a href="{{ route('gaji_bulanan.index') }}">Data Penggajian Bulanan</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
