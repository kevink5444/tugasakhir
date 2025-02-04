<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Penggajian;
use App\Models\Karyawan;
use App\Models\GajiBorongan;
use App\Models\GajiHarian;
use App\Models\GajiBulanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanAbsensi()
    {
        $absensi = Absensi::with('karyawan')->get();
        return view('laporan.absensi', compact('absensi'));
    }

    public function gajiBorongan()
    {
        $laporan = GajiBorongan::selectRaw('id_karyawan, SUM(total_gaji_borongan) AS total_gaji, MONTH(minggu_mulai) AS bulan, YEAR(minggu_mulai) AS tahun')
            ->groupBy('id_karyawan', 'bulan', 'tahun')
            ->get();

        return view('laporan.gaji_borongan', compact('laporan'));
    }

    // Laporan Gaji Harian
    public function gajiHarian()
    {
        $laporan = GajiHarian::selectRaw('id_karyawan, SUM(total_gaji_harian) AS total_gaji, MONTH(tanggal_awal) AS bulan, YEAR(tanggal_akhir) AS tahun')
            ->groupBy('id_karyawan', 'bulan', 'tahun')
            ->get();

        return view('laporan.gaji_harian', compact('laporan'));
    }

    // Laporan Gaji Bulanan
    public function gajiBulanan()
    {
        $laporan = GajiBulanan::selectRaw('id_karyawan, SUM(total_gaji_bulanan) AS total_gaji, MONTH(bulan) AS bulan, YEAR(bulan) AS tahun')
            ->groupBy('id_karyawan', 'bulan', 'tahun')
            ->get();

        return view('laporan.gaji_bulanan', compact('laporan'));
    }

    public function laporanKaryawan()
    {
        $karyawan = Karyawan::all();
        return view('laporan.karyawan', compact('karyawan'));
    }
}