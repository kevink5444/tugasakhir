@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Data Gaji Borongan</h2>
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-group">
                <label for="bulan">Pilih Bulan</label>
                <select id="bulan" class="form-control">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach ([
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember'
                    ] as $value => $nama)
                        <option value="{{ $value }}">{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="tahun">Pilih Tahun</label>
                <select id="tahun" class="form-control">
                    <option value="">-- Pilih Tahun --</option>
                    @for ($tahun = date('Y'); $tahun >= 2000; $tahun--)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary mt-4" id="filterBtn">Filter</button>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Gaji</th>
                <th>Karyawan</th>
                <th>Minggu Mulai</th>
                <th>Minggu Selesai</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Total Gaji</th>
                <th>Status Pengambilan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="gajiTableBody">
            @foreach($gajiBorongan as $gajiBulanan)
                @foreach($gajiBulanan as $gaji)
                    <tr>
                        <td>{{ $gaji->id_gaji_borongan }}</td>
                        <td>{{ $gaji->karyawan->nama_karyawan }}</td>
                        <td>{{ \Carbon\Carbon::parse($gaji->minggu_mulai)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($gaji->minggu_selesai)->format('d-m-Y') }}</td>
                        <td>{{ $gaji->bulan }}</td>
                        <td>{{ $gaji->tahun }}</td>
                        <td>{{ number_format($gaji->total_gaji_borongan, 2, ',', '.') }}</td>
                        <td>{{ $gaji->status_pengambilan }}</td>
                        <td>
                            <a href="{{ route('gaji_borongan.create') }}" class="btn btn-primary">Tambah Gaji</a>

                            <a href="{{ route('gaji_borongan.edit', [$gaji->id_gaji_borongan]) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('gaji_borongan.destroy', $gaji->id_gaji_borongan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            @if (!$gaji->status_pengambilan)
                                <a href="{{ route('gaji_borongan.ambil_gaji', $gaji->id_gaji_borongan) }}" class="btn btn-success">Ambil Gaji</a>
                            @endif
                            <a href="{{ route('gaji_borongan.cetak_slip', $gaji->id_gaji_borongan) }}" class="btn btn-info">Slip Gaji</a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('styles')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#filterBtn').click(function() {
            var selectedBulan = $('#bulan').val();
            var selectedTahun = $('#tahun').val();
            if (selectedBulan && selectedTahun) {
                // Mengirim permintaan Ajax untuk mendapatkan data
                $.ajax({
                    url: "{{ route('gaji_borongan.filter') }}", // Ganti dengan route yang sesuai
                    method: "GET",
                    data: {
                        bulan: selectedBulan,
                        tahun: selectedTahun
                    },
                    success: function(data) {
                        // Kosongkan tabel dan tambahkan data baru
                        $('#gajiTableBody').empty();
                        $.each(data.gajiBorongan, function(index, item) {
                            $('#gajiTableBody').append(`
                                <tr>
                                    <td>${item.id_gaji_borongan}</td>
                                    <td>${item.karyawan.nama_karyawan}</td>
                                    <td>${item.minggu_mulai}</td>
                                    <td>${item.minggu_selesai}</td>
                                    <td>${item.bulan}</td>
                                    <td>${item.tahun}</td>
                                    <td>${parseFloat(item.total_gaji_borongan).toLocaleString('id-ID', { minimumFractionDigits: 2 })}</td>
                                    <td>${item.status_pengambilan}</td>
                                    <td>
                                        <a href="/gaji_borongan/${item.id_gaji_borongan}/edit" class="btn btn-primary">Edit</a>
                                        <form action="/gaji_borongan/${item.id_gaji_borongan}" method="POST" style="display:inline;">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                        @if(!$gaji->status_pengambilan)
                                            <a href="/gaji_borongan/${item.id_gaji_borongan}/ambil_gaji" class="btn btn-success">Ambil Gaji</a>
                                        @endif
                                        <a href="/gaji_borongan/${item.id_gaji_borongan}/cetak_slip" class="btn btn-info">Cetak Slip</a>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                });
            } else {
                alert('Silakan pilih bulan dan tahun.');
            }
        });
    });
</script>
@endsection
