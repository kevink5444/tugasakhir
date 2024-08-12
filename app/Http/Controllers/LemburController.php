<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembur;
use App\Models\GajiBorongan;
use App\Models\Karyawan;

class LemburController extends Controller
{
    public function ajukanLembur(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'tanggal' => 'required|date',
        ]);

        $lembur = Lembur::create([
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'status_lembur' => 'pending',
        ]);

        return redirect()->back()->with('status', 'Pengajuan lembur berhasil, menunggu persetujuan.');
    }

    public function setujuiLembur($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->status_lembur = 'approved';
        $lembur->jam_lembur = now()->format('H:i:s'); // Set waktu lembur saat ini
        $lembur->bonus_lembur = $this->hitungBonusLembur($lembur);
        $lembur->save();

        // Update total lembur dan bonus lembur pada tabel gaji_borongan
        $gajiBorongan = GajiBorongan::where('id_karyawan', $lembur->id_karyawan)->first();
        if ($gajiBorongan) {
            $gajiBorongan->total_lembur += 1; // Tambah total lembur
            $gajiBorongan->bonus_lembur += $lembur->bonus_lembur; // Tambah bonus lembur
            $gajiBorongan->save();
        }

        return redirect()->back()->with('status', 'Lembur disetujui.');
    }

    public function hitungBonusLembur(Lembur $lembur)
    {
        // Asumsi bonus lembur adalah Rp 50.000 per jam
        return 50000; 
    }
}
