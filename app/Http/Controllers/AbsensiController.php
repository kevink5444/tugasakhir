<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::with('karyawan')->get(); // Menampilkan semua absensi
        return view('absensi.index', compact('absensi'));
    }

    public function create()
    {
        $karyawan = Karyawan::all(); // Ambil semua karyawan untuk form input
        return view('absensi.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'status' => 'required|in:masuk,izin,sakit,alpha',
            'waktu_masuk' => 'nullable|date_format:Y-m-d\TH:i',
            'waktu_pulang' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        $absensi = new Absensi();
        $absensi->id_karyawan = $request->id_karyawan;
        $absensi->status = $request->status;

        // Mengatur zona waktu
        $timezone = config('app.timezone');

        // Mengatur waktu masuk dan waktu pulang dengan zona waktu yang benar
        $absensi->waktu_masuk = $request->waktu_masuk 
            ? Carbon::parse($request->waktu_masuk)->setTimezone($timezone)
            : Carbon::now($timezone);

        $absensi->waktu_pulang = $request->waktu_pulang 
            ? Carbon::parse($request->waktu_pulang)->setTimezone($timezone)
            : Carbon::now($timezone);

        // Jika status 'masuk' tapi waktu masuk tidak diisi, set ke waktu sekarang
        if ($absensi->status == 'masuk' && !$absensi->waktu_masuk) {
            $absensi->waktu_masuk = Carbon::now($timezone);
        }

        // Jika status 'pulang' tapi waktu pulang tidak diisi, set ke waktu sekarang
        if ($absensi->status == 'pulang' && !$absensi->waktu_pulang) {
            $absensi->waktu_pulang = Carbon::now($timezone);
        }

        // Perhitungan bonus dan denda berdasarkan waktu masuk
        $bonus = 0;
        $denda = 0;

        if ($absensi->waktu_masuk) {
            $jamMasuk = Carbon::parse($absensi->waktu_masuk);
            $jamBatas = Carbon::today($timezone)->setTime(8, 0, 0); // Jam batas pukul 08:00:00 pada hari ini
            $jamBatasTerlambat = $jamBatas->copy()->addMinutes(5); // Jam batas terlambat pukul 08:05:00
            $jamBatasMaksDenda = $jamBatas->copy()->addHours(1); // Jam maksimal denda pukul 09:00:00

            Log::info('Jam Masuk: ' . $jamMasuk);
            Log::info('Jam Batas: ' . $jamBatas);
            Log::info('Jam Batas Terlambat: ' . $jamBatasTerlambat);
            Log::info('Jam Batas Maks Denda: ' . $jamBatasMaksDenda);

            // Perhitungan bonus
            if ($jamMasuk->lt($jamBatas)) {
                $bonus = 25000; // Bonus sebesar Rp 25.000 jika masuk sebelum pukul 08:00
            }

            // Perhitungan denda
            if ($jamMasuk->gt($jamBatasTerlambat) && $jamMasuk->lte($jamBatasMaksDenda)) {
                $denda = 10000; // Denda sebesar Rp 10.000 jika terlambat lebih dari 5 menit setelah pukul 08:00, maksimal 1 jam
            }
        }

        // Simpan nilai bonus dan denda
        $absensi->bonus = $bonus;
        $absensi->denda = $denda;
        $absensi->save();

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dicatat.');
    }
}