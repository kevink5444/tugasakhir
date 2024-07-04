<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Penggajian;
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
        'email_karyawan' => 'required|email|exists:karyawan,email_karyawan',  
    ]);

    $namaFoto = time().'.'.$request->foto->extension();
    $request->foto->move(public_path('foto'), $namaFoto);

    $tanggalHariIni = Carbon::now()->toDateString();
    $jamMasuk = Carbon::parse('08:00:00', 'Asia/Jakarta'); 
    $jamAbsen = Carbon::now('Asia/Jakarta');
    $bonus = 0;
    $denda = 0;
    $absensi = Absensi::where('email_karyawan', $request->email_karyawan)
                        ->whereDate('tanggal', $tanggalHariIni)
                        ->first();

    if ($absensi) {
        $absensi->update([
            'foto' => $namaFoto,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'jam_keluar' => $jamAbsen->toTimeString(),
        ]);
    } else {
       
        if ($jamAbsen <= $jamMasuk) {
           
            $bonus = 25000;
        } else {
            
            $denda = 10000;
        }

    
        Absensi::create([
            'foto' => $namaFoto,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'email_karyawan' => $request->email_karyawan,
            'jam_masuk' => $jamAbsen->toTimeString(),
            'tanggal' => $tanggalHariIni,
            'bonus' => $bonus,
            'denda' => $denda,
        ]);
    }
    $this->updatePenggajian($request->email_karyawan);
    return redirect()->route('absensi.form')->with('success', 'Absensi berhasil disimpan.');
}
    public function index()
    {
    $absensi = Absensi::with('karyawan')->get(); 
    return view('absensi.index', compact('absensi'));
    }
    private function updatePenggajian($email_karyawan)
    {
        $totalDenda = $this->hitungDenda($email_karyawan);
        $totalBonus = $this->hitungBonus($email_karyawan);

        $karyawan = Karyawan::where('email_karyawan', $email_karyawan)->first();

        $gajiPokok = $this->hitungGajiPokok($karyawan->status_karyawan);

        $penggajian = Penggajian::updateOrCreate(
            ['email_karyawan' => $email_karyawan],
            [
                'id_karyawan' => $karyawan->id_karyawan,
                'gaji_pokok' => $gajiPokok,
                'denda' => $totalDenda,
                'bonus' => $totalBonus,
                'total_gaji' => $gajiPokok - $totalDenda + $totalBonus,
            ]
        );
    }

    private function hitungDenda($email_karyawan)
    {
        $absensi = Absensi::where('email_karyawan', $email_karyawan)->get();
        $totalDenda = 0;

        foreach ($absensi as $item) {
            if ($item->jam_masuk > '09:00:00') {
                $totalDenda += 10000;
            }
        }

        return $totalDenda;
    }

    private function hitungBonus($email_karyawan)
    {
        $absensi = Absensi::where('email_karyawan', $email_karyawan)->get();
        $totalBonus = 0;

        foreach ($absensi as $item) {
            if ($item->jam_masuk <= '08:00:00') {
                $totalBonus += 25000;
            }
        }

        return $totalBonus;
    }

    private function hitungGajiPokok($status_karyawan)
    {
        // Contoh perhitungan gaji pokok berdasarkan status karyawan
        switch ($status_karyawan) {
            case 'Harian':
                return 100000;
            case 'Borongan':
                return 150000;
            case 'Tetap':
                return 200000;
            default:
                return 0;
            }
        }
    }