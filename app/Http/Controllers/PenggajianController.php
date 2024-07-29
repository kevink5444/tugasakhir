<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Capaian;
use App\Models\Penggajian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PenggajianController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::all();
        $penggajian = Penggajian::with('karyawan')->get();
        return view('penggajian.index', compact('penggajian', 'karyawans'));
    }

    public function hitungGaji($id_karyawan)
{
    $karyawan = Karyawan::findOrFail($id_karyawan);

    $targetHarian = $karyawan->target_harian;
    $targetMingguan = $karyawan->target_mingguan;

    $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
    $endOfWeek = Carbon::now()->endOfWeek()->toDateString();

    // Query untuk mengambil data capaian mingguan
    $capaianData = Capaian::where('id_karyawan', $id_karyawan)
                          ->whereBetween(DB::raw('DATE(tanggal)'), [$startOfWeek, $endOfWeek])
                          ->get();

    // Menghitung jumlah capaian mingguan
    $capaianMingguan = $capaianData->sum('jumlah_capaian');

    // Debugging: Pastikan data capaian mingguan terambil dengan benar
    // dd($capaianData, $capaianMingguan);

    $bonusPerUnit = 500;
    $dendaPerUnit = 200;

    // Hitung bonus hanya jika capaian melebihi target
    $bonus = max(0, $capaianMingguan - $targetMingguan) * $bonusPerUnit;

    // Hitung denda hanya jika capaian kurang dari target
    $denda = max(0, $targetMingguan - $capaianMingguan) * $dendaPerUnit;

    // Total Gaji = (capaian mingguan * bonus per unit) + bonus - denda
    $totalGaji = ($capaianMingguan * $bonusPerUnit) + $bonus - $denda;

    // Kirim data ke view
    return view('penggajian.show', compact('karyawan', 'capaianMingguan', 'bonus', 'denda', 'totalGaji'));
    }
}
