@extends('layouts.app')


@section('content')
<div class="container mt-5">
    <h1 class="text-center">Dashboard UMKM CV YP Sukses Makmur</h1>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
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
        <div class="col-md-6">
            <div class="card">
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
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Link Cepat</div>
                <div class="card-body">
                    <ul>
                        <li><a href="penggajian">Data Penggajian</a></li>
                        <li><a href="karyawan">Data Karyawan</a></li>
                        <li><a href="absensi">Data Absensi</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctxKehadiran = document.getElementById('grafikKehadiran').getContext('2d');
    var grafikKehadiran = new Chart(ctxKehadiran, {
        type: 'bar',
        data: {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            datasets: [{
                label: 'Kehadiran',
                data: [12, 19, 3, 5],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctxPenggajian = document.getElementById('grafikPenggajian').getContext('2d');
    var grafikPenggajian = new Chart(ctxPenggajian, {
        type: 'pie',
        data: {
            labels: ['Departemen A', 'Departemen B', 'Departemen C'],
            datasets: [{
                label: 'Distribusi Gaji',
                data: [30000, 50000, 20000],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
@endsection
