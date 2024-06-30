<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function buat()
    {
        $email = Auth::user()->email;
        return view('absensi.form', compact('email'));
    }

    public function simpan(Request $request)
{
    $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'email_karyawan' => 'required|email|exists:karyawan,email_karyawan',  // validasi email yang benar
    ]);

    $namaFoto = time().'.'.$request->foto->extension();
    $request->foto->move(public_path('foto'), $namaFoto);

    $tanggalHariIni = Carbon::now()->toDateString();

    $absensi = Absensi::where('email_karyawan', $request->email_karyawan)
                        ->whereDate('tanggal', $tanggalHariIni)
                        ->first();

    if ($absensi) {
        $absensi->update([
            'foto' => $namaFoto,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'jam_keluar' => Carbon::now()->toTimeString(),
        ]);
    } else {
        Absensi::create([
            'foto' => $namaFoto,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'email_karyawan' => $request->email_karyawan,
            'jam_masuk' => Carbon::now()->toTimeString(),
            'tanggal' => $tanggalHariIni,
        ]);
    }

    return redirect()->route('absensi.form')->with('success', 'Absensi berhasil disimpan.');
}
public function index()
{
    $absensi = Absensi::with('karyawan')->get(); // Menggunakan eager loading untuk mengambil relasi karyawan
    return view('absensi.index', compact('absensi'));
}
}