<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Penggajian;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanAbsensi()
    {
        $absensi = Absensi::with('karyawan')->get();
        return view('laporan.absensi', compact('absensi'));
    }

    public function laporanPenggajian()
    {
        $penggajian = Penggajian::with('karyawan')->get();
        return view('laporan.penggajian', compact('penggajian'));
    }

    public function laporanKaryawan()
    {
        $karyawan = Karyawan::all();
        return view('laporan.karyawan', compact('karyawan'));
    }
}