@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Data Absensi</h2>
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
            <button class="btn btn-primary me-2" id="filterBtn">Filter</button>
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
            </tr>
        </thead>
        <tbody id="absensiTableBody">
            @foreach($absensi as $data)
            <tr>
                <td>{{ $data->id_absensi }}</td>
                <td>{{ $data->karyawan->id_karyawan }}</td>
                <td>{{ $data->waktu_masuk }}</td>
                <td>{{ $data->waktu_pulang }}</td>
            </tr>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
   $(document).ready(function() {
    // Setup CSRF Token for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#filterBtn').on('click', function() {
        var selectedBulan = $('#bulan').val();
        var selectedTahun = $('#tahun').val();

        if (selectedBulan && selectedTahun) {
            $.ajax({
                url: '{{ route('absensi.filter') }}',
                method: 'GET',
                data: {
                    bulan: selectedBulan,
                    tahun: selectedTahun
                },
                success: function(data) {
                    var tableBody = $('#absensiTableBody');
                    tableBody.empty();

                    data.absensi.forEach(function(item) {
                        var row = '<tr>' +
                            '<td>' + item.id_absensi + '</td>' +
                            '<td>' + item.karyawan.id_karyawan + '</td>' +
                            '<td>' + item.waktu_masuk + '</td>' +
                            '<td>' + item.waktu_pulang + '</td>' +
                            '</tr>';
                        tableBody.append(row);
                    });
                },
                error: function(error) {
                    console.log('Terjadi kesalahan:', error);
                }
            });
        } else {
            alert('Silakan pilih bulan dan tahun!');
        }
    });
});
</script>
@endsection