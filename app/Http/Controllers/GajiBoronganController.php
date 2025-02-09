<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\GajiBorongan;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Lembur;
use App\Models\Pekerjaan;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
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
    $pekerjaan = Pekerjaan::all();
    return view('gaji_borongan.create', compact('karyawan', 'pekerjaan'));
}

    // Menyimpan gaji borongan baru
    public function store(Request $request)
{
    $request->validate([
        'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
        'minggu_mulai' => 'required|date',
        'minggu_selesai' => 'required|date|after_or_equal:minggu_mulai',
        'total_lembur' => 'required|numeric|min:0',
        'status_pengambilan' => 'required|string',
    ]);

    // Ambil data pekerjaan berdasarkan id_pekerjaan
    $pekerjaan = Pekerjaan::where('id_pekerjaan', $request->id_pekerjaan)->first();

    if (!$pekerjaan) {
        return back()->withErrors(['error' => 'Data pekerjaan tidak ditemukan!']);
    }

    // Hitung otomatis capaian harian
    $capaian_harian = $pekerjaan->target_harian;

    // Hitung otomatis bonus lembur
    $bonus_lembur = ($pekerjaan->gaji_per_pekerjaan / 8) * $request->total_lembur;

    // Hitung otomatis total bonus dan total denda (misalnya bonus 25.000, denda 10.000)
    $total_bonus = 25000; 
    $total_denda = 10000; 

    // Hitung total gaji borongan
    $total_gaji_borongan = ($capaian_harian * $pekerjaan->gaji_per_pekerjaan) + $bonus_lembur + $total_bonus - $total_denda;

    // Simpan data ke database
    GajiBorongan::create([
        'id_karyawan' => $request->id_karyawan,
        'id_pekerjaan' => $request->id_pekerjaan,
        'minggu_mulai' => $request->minggu_mulai,
        'minggu_selesai' => $request->minggu_selesai,
        'capaian_harian' => $capaian_harian,
        'total_lembur' => $request->total_lembur,
        'bonus_lembur' => $bonus_lembur,
        'total_bonus' => $total_bonus,
        'total_denda' => $total_denda,
        'total_gaji_borongan' => $total_gaji_borongan,
        'status_pengambilan' => $request->status_pengambilan,
    ]);

    return redirect()->route('gajiBorongan.index')->with('success', 'Gaji borongan berhasil ditambahkan.');
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
