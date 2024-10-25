<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GajiBorongan;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GajiBoronganController extends Controller
{
    // Menampilkan daftar gaji borongan
    public function index(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        // Query untuk mengambil data gaji borongan
        $query = GajiBorongan::with('karyawan');

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $gajiBorongan = $query->orderBy('created_at', 'desc')->get()->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m');
        });

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
        $validator = Validator::make($request->all(), [
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'minggu_mulai' => 'required|date',
            'minggu_selesai' => 'required|date|after:minggu_mulai',
            'total_bonus' => 'required|numeric',
            'total_denda' => 'required|numeric',
            'capaian_harian' => 'required|numeric',
            'total_lembur' => 'required|numeric',
            'bonus_lembur' => 'required|numeric',
            'status_pengambilan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Menghitung total gaji borongan
        $total_gaji_borongan = ($request->capaian_harian + $request->total_lembur + $request->bonus_lembur) + $request->total_bonus - $request->total_denda;

        GajiBorongan::create([
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

        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil ditambahkan.');
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
            'total_bonus' => 'required|numeric',
            'total_denda' => 'required|numeric',
            'capaian_harian' => 'required|numeric',
            'total_lembur' => 'required|numeric',
            'bonus_lembur' => 'required|numeric',
            'status_pengambilan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $gajiBorongan = GajiBorongan::findOrFail($id);
        
        // Menghitung total gaji borongan
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
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

    // Validasi input
    if (!$bulan || !$tahun) {
        return response()->json(['error' => 'Bulan dan tahun diperlukan'], 400);
    }

    // Query untuk mengambil data gaji borongan berdasarkan bulan dan tahun
    $gajiBorongan = GajiBorongan::with('karyawan')
        ->whereMonth('minggu_mulai', $bulan)
        ->whereYear('minggu_mulai', $tahun)
        ->orderBy('created_at', 'desc')
        ->get();

    // Return data dalam format JSON
    return response()->json(['gajiBorongan' => $gajiBorongan]);
}

}
