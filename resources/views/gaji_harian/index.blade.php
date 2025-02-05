@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Gaji Harian</h1>

    <!-- Form Filter -->
    <form action="{{ route('gaji-harian.filter') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <label for="bulan">Pilih Bulan</label>
                <select name="bulan" id="bulan" class="form-control">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach(range(1, 12) as $i)
                        <option value="{{ $i }}" {{ (isset($bulan) && $bulan == $i) ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="tahun">Pilih Tahun</label>
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach(range(date('Y'), 2000) as $year)
                        <option value="{{ $year }}" {{ (isset($tahun) && $tahun == $year) ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2" id="filterBtn">Filter</button>
                <a href="{{ route('gaji_harian.create') }}" class="btn btn-success">Tambah Gaji Harian</a>
        </div>
    </form>

    <!-- Tabel Data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Jumlah Gaji</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gajiHarian as $key => $data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->karyawan->nama_karyawan }}</td> <!-- Sesuaikan relasi jika ada -->
                    <td>{{ $data->tanggal_akhir }}</td>
                    <td>{{ number_format($data->total_gaji_harian, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pekerjaanSelect = document.getElementById('id_pekerjaan');
    const jumlahPekerjaanInput = document.getElementById('jumlah_pekerjaan');
    const capaianHarianInput = document.getElementById('capaian_harian');
    const gajiHarianInput = document.getElementById('gaji_harian');
    const bonusHarianInput = document.getElementById('bonus_harian');
    const dendaHarianInput = document.getElementById('denda_harian');

    function updateGaji() {
        const selectedOption = pekerjaanSelect.options[pekerjaanSelect.selectedIndex];
        const gajiPerPekerjaan = parseFloat(selectedOption.getAttribute('data-gaji'));
        const targetHarian = parseFloat(selectedOption.getAttribute('data-target'));
        const jumlahPekerjaan = parseFloat(jumlahPekerjaanInput.value) || 0;
        const capaianHarian = parseFloat(capaianHarianInput.value) || 0;

        // Hitung gaji harian
        const gajiHarian = jumlahPekerjaan * gajiPerPekerjaan;

        // Hitung bonus dan denda
        let bonusHarian = 0;
        let dendaHarian = 0;

        if (capaianHarian >= targetHarian) {
            bonusHarian = gajiHarian * 0.2; // 20% dari gaji harian
        }

        if (jumlahPekerjaan < targetHarian) {
            dendaHarian = gajiHarian * 0.05; // 5% dari gaji harian
        }

        // Update input fields
        gajiHarianInput.value = Rp ${gajiHarian.toFixed(0)};
        bonusHarianInput.value = Rp ${bonusHarian.toFixed(0)};
        dendaHarianInput.value = Rp ${dendaHarian.toFixed(0)};
    }

    pekerjaanSelect.addEventListener('change', updateGaji);
    jumlahPekerjaanInput.addEventListener('input', updateGaji);
    capaianHarianInput.addEventListener('input', updateGaji);
    updateGaji(); // Initial calculation based on default values
});
</script>
@endsection