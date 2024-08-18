<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GajiBorongan;
use App\Models\Karyawan;
use App\Models\Absensi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class GajiBoronganController extends Controller
{
    public function index()
    {
        $gaji_borongan = GajiBorongan::with('karyawan')->get();
        return view('gaji_borongan.index', compact('gaji_borongan'));
    }

    public function create()
    {
        $karyawan = Karyawan::all();
        return view('gaji_borongan.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'tanggal' => 'required|date',
            'pekerjaan' => 'required|in:kancing,lubang,obras_baju,obras_tangan,obras_lengan',
            'jumlah_pekerjaan' => 'required|integer',
            'capaian_harian' => 'required|integer',
        ]);

        $harga_per_unit = [
            'kancing' => 1200,
            'lubang' => 1260,
            'obras_baju' => 1900,
            'obras_tangan' => 1500,
            'obras_lengan' => 1200,
        ];

        $capaian_harian = [
            'kancing' => 350,
            'lubang' => 300,
            'obras_baju' => 550,
            'obras_tangan' => 600,
            'obras_lengan' => 1000,
        ];

        $pekerjaan = $request->pekerjaan;
        $jumlah_pekerjaan = $request->jumlah_pekerjaan;
        $capaian_harian = $capaian_harian[$pekerjaan];
        $harga = $harga_per_unit[$pekerjaan];

        $total_gaji = $capaian_harian * $harga;
        $bonus = ($jumlah_pekerjaan >= $capaian_harian) ? 0.20 * $total_gaji : 0;
        $denda = ($jumlah_pekerjaan < $capaian_harian) ? 0.05 * $total_gaji : 0;

        $absensi = Absensi::where('id_karyawan', $request->id_karyawan)
                          ->whereDate('tanggal', $request->tanggal)
                          ->first();
        $bonus_absensi = 0;
        $denda_absensi = 0;
        if ($absensi) {
            $jam_masuk = new Carbon($absensi->jam_masuk);
            if ($jam_masuk->hour < 8 || ($jam_masuk->hour == 8 && $jam_masuk->minute <= 0)) {
                $bonus_absensi = 25000;
            } else if ($jam_masuk->hour > 8) {
                $denda_absensi = 10000;
            }
        }

        GajiBorongan::create([
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'pekerjaan' => $pekerjaan,
            'capaian_harian' => $capaian_harian,
            'harga_per_unit' => $harga,
            'total_gaji' => $total_gaji,
            'bonus' => $bonus,
            'denda' => $denda,
            'bonus_absensi' => $bonus_absensi,
            'denda_absensi' => $denda_absensi,
        ]);

        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gaji_borongan = GajiBorongan::findOrFail($id);
        $karyawan = Karyawan::all();
        return view('gaji_borongan.edit', compact('gaji_borongan', 'karyawan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'tanggal' => 'required|date',
            'pekerjaan' => 'required|in:kancing,lubang,obras_baju,obras_tangan,obras_lengan',
            'jumlah_pekerjaan' => 'required|integer',
            'capaian_harian' => 'required|integer',
        ]);

        $gaji_borongan = GajiBorongan::findOrFail($id);
        $harga_per_unit = [
            'kancing' => 1200,
            'lubang' => 1260,
            'obras_baju' => 1900,
            'obras_tangan' => 1500,
            'obras_lengan' => 1200,
        ];

        $capaian_harian = [
            'kancing' => 350,
            'lubang' => 300,
            'obras_baju' => 550,
            'obras_tangan' => 600,
            'obras_lengan' => 1000,
        ];

        $pekerjaan = $request->pekerjaan;
        $jumlah_pekerjaan = $request->jumlah_pekerjaan;
        $target = $capaian_harian[$pekerjaan];
        $harga = $harga_per_unit[$pekerjaan];

        $total_gaji = $jumlah_pekerjaan * $harga;
        $bonus = ($jumlah_pekerjaan >= $target) ? 0.20 * $total_gaji : 0;
        $denda = ($jumlah_pekerjaan < $target) ? 0.05 * $total_gaji : 0;

        $absensi = Absensi::where('id_karyawan', $request->id_karyawan)
                          ->whereDate('tanggal', $request->tanggal)
                          ->first();
        $bonus_absensi = 0;
        $denda_absensi = 0;
        if ($absensi) {
            $jam_masuk = new Carbon($absensi->jam_masuk);
            if ($jam_masuk->hour < 8 || ($jam_masuk->hour == 8 && $jam_masuk->minute <= 0)) {
                $bonus_absensi = 25000;
            } else if ($jam_masuk->hour > 8) {
                $denda_absensi = 10000;
            }
        }

        $gaji_borongan->update([
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'pekerjaan' => $pekerjaan,
            'jumlah_pekerjaan' => $jumlah_pekerjaan,
            'capaian_harian' => $capaian_harian,
            'harga_per_unit' => $harga,
            'total_gaji' => $total_gaji,
            'bonus' => $bonus,
            'denda' => $denda,
            'bonus_absensi' => $bonus_absensi,
            'denda_absensi' => $denda_absensi,
        ]);

        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gaji_borongan = GajiBorongan::findOrFail($id);
        $gaji_borongan->delete();
        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil dihapus.');
    }

    public function ambilGaji($id)
    {
        $gaji_borongan = GajiBorongan::findOrFail($id);

        if ($gaji_borongan->status_pengambilan) {
            return redirect()->route('gaji_borongan.index')->with('error', 'Gaji sudah diambil.');
        }

        $gaji_borongan->update(['status_pengambilan' => 1]);

        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji berhasil diambil.');
    }

    public function cetakSlipGaji($id)
    {
        $gaji_borongan = GajiBorongan::findOrFail($id);
        $pdf = Pdf::loadView('gaji_borongan.slip', compact('gaji_borongan'));
        return $pdf->download('slip_gaji_' . $gaji_borongan->id_gaji_borongan . '.pdf');
    }
}