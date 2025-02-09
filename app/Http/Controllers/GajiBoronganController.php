<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\GajiBorongan;
use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GajiBoronganController extends Controller
{
    // Menampilkan daftar gaji borongan
    public function index(Request $request)
    {
        $query = GajiBorongan::with('karyawan');
    
        if ($request->filled('bulan')) {
            $query->whereMonth('minggu_mulai', $request->bulan);
        }
    
        if ($request->filled('tahun')) {
            $query->whereYear('minggu_mulai', $request->tahun);
        }
    
        $gajiBorongan = $query->get();
    
        return view('gaji_borongan.index', compact('gajiBorongan'));
    }

    // Menampilkan form pembuatan gaji borongan baru
    public function create()
{
    $karyawan = Karyawan::all();
    return view('gaji_borongan.create', compact('karyawan'));
}

    // Menyimpan gaji borongan baru
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        'tanggal' => 'required|date',
        'waktu_masuk' => 'required|date_format:H:i:s',
        'waktu_pulang' => 'required|date_format:H:i:s',
        'jam_lembur' => 'nullable|numeric|min:0',
        'gaji_per_hari' => 'required|numeric|min:0',
    ]);

    // Data yang dibutuhkan
    $waktuMasuk = $request->waktu_masuk;
    $waktuPulang = $request->waktu_pulang;
    $jamLembur = $request->jam_lembur ?? 0;
    $gajiPerHari = $request->gaji_per_hari;
    $waktuMasukCarbon = Carbon::parse($waktuMasuk);
    $waktuPulangCarbon = Carbon::parse($waktuPulang);
    $totalJamKerja = $waktuPulangCarbon->diffInHours($waktuMasukCarbon);
    
    if ($totalJamKerja > 8) {
        $jamLembur = $totalJamKerja - 8;
    } else {
        $jamLembur = 0;
    }
    
    $gajiPerJam = $gajiPerHari / 8;
    $lembur = $gajiPerJam * $jamLembur;
    // Hitung bonus jika hadir tepat waktu (<= 08:00:00)
    $jamMasukTepat = '08:00:00'; // Jam masuk ideal
    $bonus = (strtotime($waktuMasuk) <= strtotime($jamMasukTepat)) ? 25000 : 0;

    // Hitung denda jika terlambat (> 08:00:00)
    $denda = (strtotime($waktuMasuk) > strtotime($jamMasukTepat)) ? 10000 : 0;

    // Hitung lembur (gaji per hari dibagi 8 jam)
    $gajiPerJam = $gajiPerHari / 8;
    $lembur = $gajiPerJam * $jamLembur;

    // Hitung total gaji
    $totalGaji = $gajiPerHari + $bonus - $denda + $lembur;

    // Simpan ke database
    GajiBorongan::create([
        'id_karyawan' => $request->id_karyawan,
        'tanggal' => $request->tanggal,
        'waktu_masuk' => $waktuMasuk,
        'waktu_pulang' => $waktuPulang,
        'jam_lembur' => $jamLembur,
        'gaji_per_hari' => $gajiPerHari,
        'bonus' => $bonus,
        'denda' => $denda,
        'lembur' => $lembur,
        'total_gaji_borongan' => $totalGaji,
    ]);
    

    return redirect()->back()->with('success', 'Gaji berhasil dihitung dan disimpan.');
}


    // Menampilkan form edit gaji borongan
    public function edit($id)
    {
        $gajiBorongan = GajiBorongan::findOrFail($id);
        $karyawan = Karyawan::all();
        return view('gaji_borongan.edit', compact('gajiBorongan', 'karyawan'));
    }
    // Memperbarui gaji borongan
    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        'minggu_mulai' => 'required|date',
        'minggu_selesai' => 'required|date|after:minggu_mulai',
        'total_bonus' => 'required|numeric|min:0',
        'total_denda' => 'required|numeric|min:0',
        'capaian_harian' => 'required|numeric|min:0',
        'total_lembur' => 'required|numeric|min:0',
        'bonus_lembur' => 'required|numeric|min:0',
        'status_pengambilan' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $gajiBorongan = GajiBorongan::findOrFail($id);
    
    $total_gaji_borongan = ($request->capaian_harian + $request->total_lembur + $request->bonus_lembur) + $request->total_bonus - $request->total_denda;

    $gajiBorongan->update([
        'id_karyawan' => $request->id_karyawan,
        'minggu_mulai' => $request->minggu_mulai,
        'minggu_selesai' => $request->minggu_selesai,
        'bulan' => date('n', strtotime($request->minggu_mulai)),
        'tahun' => date('Y', strtotime($request->minggu_mulai)),
        'total_gaji_borongan' => $total_gaji_borongan,
        'total_bonus' => $request->total_bonus,
        'total_denda' => $request->total_denda,
        'capaian_harian' => $request->capaian_harian,
        'total_lembur' => $request->total_lembur,
        'bonus_lembur' => $request->bonus_lembur,
        'status_pengambilan' => $request->status_pengambilan,
    ]);

    return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil diperbarui.');
}

    // Fungsi untuk mengambil gaji
    public function ambilGaji($id)
    {
        $gaji_borongan = GajiBorongan::findOrFail($id);

        if ($gaji_borongan->status_pengambilan) {
            return redirect()->back()->with('error', 'Gaji borongan sudah diambil.');
        }

        $gaji_borongan->status_pengambilan = 1;
        $gaji_borongan->save();

        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil diambil.');
    }

    // Fungsi untuk mencetak slip gaji
    public function cetakSlipGaji($id)
    {
        $gaji_borongan = GajiBorongan::findOrFail($id);

        $pdf = Pdf::loadView('gaji_borongan.slip_gaji', compact('gaji_borongan'));

        return $pdf->download('slip_gaji_borongan_' . $gaji_borongan->id . '.pdf');
    }

    // Menghapus data gaji borongan
    public function destroy($id)
    {
        $gaji_borongan = GajiBorongan::findOrFail($id);
        $gaji_borongan->delete();

        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil dihapus.');
    }
    public function filter(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    $gajiBorongan = GajiBorongan::whereMonth('minggu_mulai', $bulan)
        ->whereYear('minggu_mulai', $tahun)
        ->get(); // Ini mengembalikan collection
    
    return view('gaji_borongan.index', compact('gajiBorongan'));
}
public function getCapaian($id_karyawan)
    {
        $karyawan = Karyawan::find($id_karyawan);
        return response()->json(['capaian_harian' => $karyawan->capaian_harian]);
    }

    public function getAbsensiBonus($id_karyawan)
    {
        $total_bonus = Absensi::where('id_karyawan', $id_karyawan)
            ->where('status_kehadiran', 'tepat_waktu')
            ->count() * 25000;

        return response()->json(['total_bonus' => $total_bonus]);
    }

    public function getAbsensiDenda($id_karyawan)
    {
        $total_denda = Absensi::where('id_karyawan', $id_karyawan)
            ->where('status_kehadiran', 'terlambat')
            ->count() * 10000;

        return response()->json(['total_denda' => $total_denda]);
    }

}
