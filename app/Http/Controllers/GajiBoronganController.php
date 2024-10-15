<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GajiBorongan;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
class GajiBoronganController extends Controller
{
    // Menampilkan daftar gaji borongan
    public function index()
    {
        // Mengambil data dengan relasi karyawan dan dikelompokkan berdasarkan tahun dan bulan
        $gajiBorongan = GajiBorongan::with('karyawan')->get();
        return view('gaji_borongan.index', compact('gajiBorongan'));
    }

    // Menampilkan form pembuatan gaji borongan baru
    public function create()
    {
        $karyawan = Karyawan::all(); // Mengambil semua data karyawan
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

        // Menghitung total gaji borongan secara otomatis
        $total_gaji_borongan = ($request->capaian_harian + $request->total_lembur + $request->bonus_lembur) + $request->total_bonus - $request->total_denda;

        // Menyimpan data gaji borongan baru
        GajiBorongan::create([
            'id_karyawan' => $request->id_karyawan,
            'minggu_mulai' => $request->minggu_mulai,
            'minggu_selesai' => $request->minggu_selesai,
            'bulan' => date('n', strtotime($request->minggu_mulai)), // Mengambil bulan dari tanggal mulai
            'tahun' => date('Y', strtotime($request->minggu_mulai)), // Mengambil tahun dari tanggal mulai
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
        $karyawan = Karyawan::all(); // Mengambil semua data karyawan
        return view('gaji_borongan.edit', compact('gajiBorongan', 'karyawan'));
    }

    // Memperbarui gaji borongan yang ada
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_karyawan' => 'required|exists:karyawan,id',
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
        
        // Menghitung total gaji borongan secara otomatis
        $total_gaji_borongan = ($request->capaian_harian + $request->total_lembur + $request->bonus_lembur) + $request->total_bonus - $request->total_denda;

        // Memperbarui data gaji borongan
        $gajiBorongan->update([
            'id_karyawan' => $request->id_karyawan,
            'minggu_mulai' => $request->minggu_mulai,
            'minggu_selesai' => $request->minggu_selesai,
            'bulan' => date('n', strtotime($request->minggu_mulai)), // Mengupdate bulan
            'tahun' => date('Y', strtotime($request->minggu_mulai)), // Mengupdate tahun
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
    public function ambilGaji($id)
{
    $gaji_borongan = GajiBorongan::findOrFail($id);

    if ($gaji_borongan->status_pengambilan) {
        return redirect()->back()->with('error', 'Gaji borongan sudah diambil.');
    }

    // Tandai gaji sudah diambil
    $gaji_borongan->status_pengambilan = 1;
    $gaji_borongan->save();

    return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil diambil.');
}
public function cetakSlipGaji($id)
{
    $gaji_borongan = GajiBorongan::findOrFail($id);

    // Menghitung total gaji borongan dalam periode
    $totalGajiPeriode = $gaji_borongan->total_gaji_borongan; // Total sudah disimpan dalam database

    return view('gaji_borongan.slip_gaji', compact('gaji_borongan', 'totalGajiPeriode'));

    // Membuat PDF slip gaji
    $pdf = Pdf::loadView('gaji_borongan.slip_gaji', compact('gaji_borongan', 'totalGajiPeriode'));

    return $pdf->download('slip_gaji_borongan_' . $gaji_borongan->id . '.pdf');
}
public function downloadPdf($id)
{
    $gaji_borongan = GajiBorongan::findOrFail($id);

    // Membuat PDF slip gaji
    $pdf = Pdf::loadView('gaji_borongan.slip_gaji', compact('gaji_borongan'));

    return $pdf->download('slip_gaji_borongan_' . $gaji_borongan->id . '.pdf');
}
public function destroy($id)
{
    $gaji_borongan = GajiBorongan::findOrFail($id);
    $gaji_borongan->delete();

    return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil dihapus.');
}

}