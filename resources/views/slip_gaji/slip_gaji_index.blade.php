@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Slip Gaji untuk {{ $karyawan->nama }}</h2>
    
    @foreach($slipGaji as $slip)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Slip Gaji {{ ucfirst($slip->periode) }} - {{ $slip->tanggal_slip->format('d M Y') }}</h5>
                <p class="card-text">Total Gaji: Rp {{ number_format($slip->total_gaji, 2) }}</p>
                <p class="card-text">Bonus: Rp {{ number_format($slip->bonus, 2) }}</p>
                <p class="card-text">Denda: Rp {{ number_format($slip->denda, 2) }}</p>
                
                @if($slip->periode == 'mingguan')
                    <p class="card-text">Total Pekerjaan: {{ $slip->total_pekerjaan }}</p>
                    <p class="card-text">Total Lembur: {{ $slip->total_lembur }} jam</p>
                    <p class="card-text">Bonus Lembur: Rp {{ number_format($slip->bonus_lembur, 2) }}</p>
                @endif
                
                @if($slip->periode == 'bulanan')
                    <p class="card-text">Uang Transport: Rp {{ number_format($slip->uang_transport, 2) }}</p>
                    <p class="card-text">Uang Makan: Rp {{ number_format($slip->uang_makan, 2) }}</p>
                    <p class="card-text">THR: Rp {{ number_format($slip->thr, 2) }}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection