<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\GajiBulanan;
use App\Models\GajiMingguan;
use App\Models\GajiHarian;
use App\Models\SlipGaji;
use Carbon\Carbon;

class PenggajianController extends Controller
{
    // Menampilkan halaman utama penggajian
    public function index()
    {
        return view('penggajian.index');
    }

    // Menampilkan data gaji bulanan
    public function showGajiBulanan()
    {
        $gaji_bulanan = GajiBulanan::with('karyawan')->get();
        return view('penggajian.gaji_bulanan', compact('gaji_bulanan'));
    }

    // Menampilkan data gaji mingguan
   

    // Menghitung dan menyimpan gaji bulanan
    public function generateGajiBulanan()
    {
        $karyawanTetap = Karyawan::where('jenis_karyawan', 'Tetap')->get();
    
        foreach ($karyawanTetap as $karyawan) {
            $lastPaidAt = $karyawan->last_paid_at;
            $currentMonth = Carbon::now()->startOfMonth();
    
            if ($lastPaidAt && $lastPaidAt->greaterThanOrEqualTo($currentMonth)) {
                continue;
            }
    
            $gajiBulanan = new GajiBulanan();
            $gajiBulanan->id_karyawan = $karyawan->id;
            $gajiBulanan->bulan = $currentMonth;
            $gajiBulanan->gaji_pokok = 5000000;
            $gajiBulanan->uang_transport = 250000;
            $gajiBulanan->uang_makan = 300000;
            $gajiBulanan->bonus = 500000;
            $gajiBulanan->thr = 0;
            $gajiBulanan->total_lembur = 10;
            $gajiBulanan->bonus_lembur = $gajiBulanan->total_lembur * 10000;
            $gajiBulanan->denda = 50000;
            $gajiBulanan->total_gaji = $gajiBulanan->gaji_pokok
                                  + $gajiBulanan->uang_transport
                                  + $gajiBulanan->uang_makan
                                  + $gajiBulanan->bonus
                                  + $gajiBulanan->thr
                                  + $gajiBulanan->bonus_lembur
                                  - $gajiBulanan->denda;
            $gajiBulanan->save();
    
            $karyawan->last_paid_at = now();
            $karyawan->save();
        }
    
        return redirect()->route('penggajian.gaji_bulanan')->with('success', 'Gaji bulanan berhasil dihitung.');
    }
    
    // Menghitung dan menyimpan gaji mingguan
    public function generateGajiMingguan()
    {
        $karyawanHarianBorongan = Karyawan::whereIn('jenis_karyawan', ['Harian', 'Borongan'])->get();
    
        foreach ($karyawanHarianBorongan as $karyawan) {
            $lastPaidAt = $karyawan->last_paid_at;
            $currentWeek = Carbon::now()->startOfWeek();
    
            if ($lastPaidAt && $lastPaidAt->greaterThanOrEqualTo($currentWeek)) {
                continue;
            }
    
            $mingguMulai = Carbon::now()->startOfWeek();
            $mingguSelesai = Carbon::now()->endOfWeek();
    
            $gajiHarian = GajiHarian::where('id_karyawan', $karyawan->id)
                                    ->whereBetween('tanggal', [$mingguMulai, $mingguSelesai])
                                    ->get();
    
            $totalGajiMingguan = 0;
            $totalBonus = 0;
            $totalDenda = 0;
            $totalPekerjaan = 0;
            $totalLembur = 0;
            $bonusLembur = 0;
    
            foreach ($gajiHarian as $hari) {
                $totalGajiMingguan += $hari->gaji_harian;
                $totalBonus += $hari->bonus_harian;
                $totalDenda += $hari->denda_harian;
                $totalPekerjaan += $hari->jumlah_pekerjaan;
            }
    
        
        
    
            $karyawan->last_paid_at = now();
            $karyawan->save();
        }
    
        return redirect()->route('penggajian.gaji_mingguan')->with('success', 'Gaji mingguan berhasil dihitung.');
    }

    // Menampilkan slip gaji untuk karyawan tertentu
    public function showSlipGaji($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $slipGaji = SlipGaji::where('id_karyawan', $id_karyawan)->get();
        
        return view('penggajian.slip_gaji', compact('karyawan', 'slipGaji'));
    }
}