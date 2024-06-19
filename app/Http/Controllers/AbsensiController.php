<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import model User jika memerlukan informasi nama karyawan

class AbsensiController extends Controller
{
    public function checkIn(Request $request)
    {
        $id_karyawan = $request->input('id_karyawan');
        $user = User::find($id_karyawan); // Mengambil data pengguna berdasarkan id_karyawan
        $waktu_sekarang = Carbon::now();

        // Logika untuk menentukan status terlambat atau tepat waktu
        $waktu_masuk = Carbon::parse('08:00:00');
        $status = $waktu_sekarang->gt($waktu_masuk) ? 'terlambat' : 'tepat_waktu';
        
        // Hitung jumlah jika diperlukan
        $jumlah = $status == 'terlambat' ? -25000 : 50000;

        // Simpan data absensi ke dalam tabel
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
        // Ambil data absensi yang belum checkout
        $absensi = Absensi::where('id_karyawan', $request->input('id_karyawan'))
                          ->whereNull('waktu_keluar')
                          ->first();

        if ($absensi) {
            // Update waktu keluar jika absensi ditemukan
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
            return redirect()->route('login');
        }

        return view('absensi.form');
    }

    public function index()
    {
        // Ambil semua data absensi dari database
        $absensi = Absensi::all();
        return view('absensi.index', compact('absensi'));
    }
}
