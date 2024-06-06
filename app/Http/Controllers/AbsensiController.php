<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Penggajian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('absensi');
    }

    public function absenMasuk($id_karyawan)
    {
        $absensi = Absensi::where('id_karyawan', $id_karyawan)
                          ->whereDate('waktu_masuk', Carbon::today())
                          ->first();

        if (!$absensi) {
            $absensi = Absensi::create([
                'id_karyawan' => $id_karyawan,
                'waktu_masuk' => Carbon::now(),
            ]);

            $batas_waktu_masuk = Carbon::today()->setTime(8, 0, 0);
            if (Carbon::now()->lessThanOrEqualTo($batas_waktu_masuk)) {
                Penggajian::create([
                    'id_karyawan' => $id_karyawan,
                    'jumlah' => 50000,
                    'keterangan' => 'Bonus absen tepat waktu'
                ]);
            } else if (Carbon::now()->greaterThan($batas_waktu_masuk->addMinutes(10))) {
                Penggajian::create([
                    'id_karyawan' => $id_karyawan,
                    'jumlah' => -25000,
                    'keterangan' => 'Denda keterlambatan'
                ]);
            }

            return response()->json(['message' => 'Absen masuk berhasil'], 200);
        } else {
            return response()->json(['message' => 'Anda sudah absen masuk hari ini'], 400);
        }
    }

    public function absenKeluar($id_karyawan)
    {
        $absensi = Absensi::where('id_karyawan', $id_karyawan)
                          ->whereDate('waktu_masuk', Carbon::today())
                          ->first();

        if ($absensi) {
            $absensi->update(['waktu_keluar' => Carbon::now()]);
            return response()->json(['message' => 'Absen keluar berhasil'], 200);
        } else {
            return response()->json(['message' => 'Anda belum absen masuk hari ini'], 400);
        }
    }
}
