@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Data Absensi</h2>
    <form action="{{ route('absensi.filter') }}" method="GET" class="mb-3">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <div class="col-md-4 d-flex align-items-end">
            <button type="button" class="btn btn-primary me-2" id="filterBtn">Filter</button>
            <a href="{{ route('absensi.create') }}" class="btn btn-success">Tambah Absensi</a>
        </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Karyawan</th>
                <th>Waktu Masuk</th>
                <th>Waktu Pulang</th>
                <th>Bonus</th>
                <th>Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="absensiTableBody">
            @foreach($absensi as $data)
            <tr>
                <td>{{ $data->id_absensi }}</td>
                <td>{{ $data->karyawan->id_karyawan }}</td>
                <td>{{ $data->waktu_masuk }}</td>
                <td>{{ $data->waktu_pulang }}</td>
                <td>{{ $data->bonus }}</td>
                <td>{{ $data->denda }}</td>
                <td>{{ $data->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    function loadAbsensi(bulan = '', tahun = '') {
        $.ajax({
            url: '/absensi/filter',
            type: 'GET',
            data: { bulan: bulan, tahun: tahun },
            dataType: 'json',
            success: function(data) {
                var tableBody = $('#absensiTableBody');
                tableBody.empty();

                if (data.absensi.length === 0) {
                    tableBody.append('<tr><td colspan="7">Data tidak ditemukan</td></tr>');
                } else {
                    data.absensi.forEach(function(item) {
                        var row = '<tr>' +
                            '<td>' + item.id_absensi + '</td>' +
                            '<td>' + item.karyawan.id_karyawan + '</td>' +
                            <td>{{ $data->waktu_masuk ?? '-' }}</td>
                            <td>{{ $data->waktu_pulang ?? '-' }}</td>
                            '<td>' + item.bonus + '</td>' +
                            '<td>' + item.denda + '</td>' +
                            '<td>' + item.status + '</td>' +
                            '</tr>';
                        tableBody.append(row);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    loadAbsensi();

    $('#filterBtn').click(function() {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        loadAbsensi(bulan, tahun);
    });
});
</script>
@endsection
