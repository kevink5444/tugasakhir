<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\GajiBulanan;
use App\Models\GajiHarian;
use App\Models\GajiBorongan;
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

        $timezone = config('app.timezone');

        $absensi->waktu_masuk = $request->waktu_masuk 
            ? Carbon::parse($request->waktu_masuk)->setTimezone($timezone)
            : Carbon::now($timezone);

        $absensi->waktu_pulang = $request->waktu_pulang 
            ? Carbon::parse($request->waktu_pulang)->setTimezone($timezone)
            : Carbon::now($timezone);

        $bonus = 0;
        $denda = 0;

        if ($absensi->waktu_masuk) {
            $jamMasuk = Carbon::parse($absensi->waktu_masuk);
            $jamBatas = Carbon::today($timezone)->setTime(8, 0, 0);
            $jamBatasTerlambat = $jamBatas->copy()->addMinutes(5);
            $jamBatasMaksDenda = $jamBatas->copy()->addHours(1);

            if ($jamMasuk->lt($jamBatas)) {
                $bonus = 25000;
            }

            if ($jamMasuk->gt($jamBatasTerlambat) && $jamMasuk->lte($jamBatasMaksDenda)) {
                $denda = 10000;
            }
        }

        $absensi->bonus = $bonus;
        $absensi->denda = $denda;
        $absensi->save();

        // Integrasi bonus dan denda ke dalam gaji
        $this->updateGaji($absensi);

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dicatat.');
    }

    private function updateGaji(Absensi $absensi)
    {
        $karyawan = $absensi->karyawan;
        $bulan = Carbon::now()->format('Y-m');
    
        switch ($karyawan->tipe_gaji) {
            case 'bulanan':
                $gaji = GajiBulanan::firstOrCreate(
                    ['id_karyawan' => $karyawan->id_karyawan, 'bulan' => $bulan],
                    ['total_gaji' => 0, 'bonus' => 0, 'denda' => 0]
                );
                break;
    
            case 'harian':
                $tanggal = Carbon::now()->format('Y-m-d');
                $gaji = GajiHarian::firstOrCreate(
                    ['id_karyawan' => $karyawan->id_karyawan, 'tanggal' => $tanggal],
                    ['total_gaji' => 0, 'bonus' => 0, 'denda' => 0]
                );
                break;
    
            case 'borongan':
                $gaji = GajiBorongan::firstOrCreate(
                    ['id_karyawan' => $karyawan->id_karyawan, 'bulan' => $bulan],
                    ['total_gaji' => 0, 'bonus' => 0, 'denda' => 0]
                );
                break;
    
            // Tambahkan default case untuk menangani tipe_gaji yang tidak dikenali
            default:
                return back()->with('error', 'Tipe gaji karyawan tidak valid.');
        }
    
        // Pastikan variabel $gaji sudah didefinisikan dan tidak null
        if (isset($gaji)) {
            // Update bonus dan denda jika gaji ditemukan atau berhasil dibuat
            $gaji->bonus += $absensi->bonus;
            $gaji->denda += $absensi->denda;
            $gaji->save();
        } else {
            // Logging atau handling error
            Log::error('Gagal memperbarui gaji: Objek gaji tidak ditemukan atau tidak bisa dibuat.');
        }
    
    }
}