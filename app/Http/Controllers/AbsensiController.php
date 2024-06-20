<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function checkIn(Request $request)
    {
        $id_karyawan = Auth::id();
        $waktu_sekarang = Carbon::now();
        $waktu_masuk = Carbon::parse('08:00:00');

        $status = $waktu_sekarang->gt($waktu_masuk) ? 'terlambat' : 'tepat_waktu';
        $jumlah = $status == 'terlambat' ? -25000 : 50000;

        Absensi::create([
            'id_karyawan' => $id_karyawan,
            'waktu_masuk' => $waktu_sekarang,
            'status' => $status,
            'jumlah' => $jumlah,
        ]);

        return response()->json(['message' => 'Check-in berhasil']);
    }

    public function checkOut(Request $request)
    {
        $id_karyawan = Auth::id();
        $absensi = Absensi::where('id_karyawan', $id_karyawan)
                          ->whereNull('waktu_keluar')
                          ->first();

        if ($absensi) {
            $absensi->update([
                'waktu_keluar' => Carbon::now()
            ]);
            return response()->json(['message' => 'Check-out berhasil']);
        }

        return response()->json(['message' => 'Gagal melakukan check-out'], 400);
    }

    public function showForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('absensi.form');
    }

    public function index()
    {
        $absensi = Absensi::all();
        return view('absensi.index', compact('absensi'));
    }
}
