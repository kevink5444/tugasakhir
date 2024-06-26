@extends('layouts.app')

@section('content')
<h1 class="my-4 text-center">Edit Penggajian</h1>
    <form action="{{ route('penggajian.update', $penggajian->id_penggajian) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_karyawan">Nama Karyawan</label>
            <input type="text" id="id_karyawan" name="id_karyawan" class="form-control" value="{{ $penggajian->karyawan->nama_karyawan ?? '' }}" readonly>
        </div>
        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="number" id="gaji_pokok" name="gaji_pokok" class="form-control" value="{{ old('gaji_pokok', $penggajian->gaji_pokok) }}" required>
        </div>
        <div class="form-group">
            <label for="bonus">Bonus</label>
            <input type="number" id="bonus" name="bonus" class="form-control" value="{{ old('bonus', $penggajian->bonus) }}">
        </div>
        <div class="form-group">
            <label for="denda">Denda</label>
            <input type="number" id="denda" name="denda" class="form-control" value="{{ old('denda', $penggajian->denda) }}">
        </div>
        <div class="form-group">
            <label for="total_gaji">Total Gaji</label>
            <input type="number" id="total_gaji" name="total_gaji" class="form-control" value="{{ old('total_gaji', $penggajian->total_gaji) }}" readonly>
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const gajiPokokInput = document.getElementById('gaji_pokok');
            const bonusInput = document.getElementById('bonus');
            const dendaInput = document.getElementById('denda');
            const totalGajiInput = document.getElementById('total_gaji');

            function calculateTotalGaji() {
                const gajiPokok = parseFloat(gajiPokokInput.value) || 0;
                const bonus = parseFloat(bonusInput.value) || 0;
                const denda = parseFloat(dendaInput.value) || 0;

                const totalGaji = gajiPokok + bonus - denda;
                totalGajiInput.value = totalGaji.toFixed(2);
            }

            gajiPokokInput.addEventListener('input', calculateTotalGaji);
            bonusInput.addEventListener('input', calculateTotalGaji);
            dendaInput.addEventListener('input', calculateTotalGaji);
            
            // Initial calculation
            calculateTotalGaji();
        });
    </script>
@endsection
