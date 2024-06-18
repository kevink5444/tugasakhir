<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk mengimpor alias Auth

class AbsensiController extends Controller
{
    public function checkIn(Request $request)
    {
        $id_karyawan = $request->input('id_karyawan');
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
        $absensi = Absensi::where('id_karyawan', $request->input('id_karyawan'))
                          ->whereNull('waktu_keluar')
                          ->first();

        if ($absensi) {
            $absensi->update([
                'waktu_keluar' => Carbon::now()
            ]);
        }

        return response()->json(['message' => 'Check-out berhasil']);
    }

    public function showForm()
    {
        // Pastikan pengguna sudah terautentikasi sebelum mengakses halaman
        if (!Auth::check()) {
            return redirect()->route('login'); // Ganti 'login' dengan rute login yang sesuai
        }

        return view('absensi.form');
    }
}
