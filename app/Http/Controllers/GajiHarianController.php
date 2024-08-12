<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GajiHarian;
use App\Models\Karyawan;
use App\Models\Pekerjaan;
use App\Models\Absensi;
use Dompdf\Dompdf;
use Dompdf\Options;

class GajiHarianController extends Controller
{
    public function index()
    {
        $gaji_harian = GajiHarian::with('karyawan', 'pekerjaan')->get();
        return view('gaji_harian.index', compact('gaji_harian'));
    }

    public function create()
    {
        $karyawan = Karyawan::all();
        $pekerjaan = Pekerjaan::all();
        return view('gaji_harian.create', compact('karyawan', 'pekerjaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'tanggal' => 'required|date',
            'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
            'jumlah_pekerjaan' => 'required|numeric',
            'target_harian' => 'required|numeric',
            'capaian_harian' => 'required|numeric',
        ]);

        $pekerjaan = Pekerjaan::find($request->id_pekerjaan);
        $gaji_harian = $pekerjaan->gaji;
        $target_harian = $pekerjaan->target;

        // Menghitung bonus dan denda berdasarkan absensi
        $absensi = Absensi::where('id_karyawan', $request->id_karyawan)
                           ->whereDate('tanggal', $request->tanggal)
                           ->first();
                           
        $bonus_harian = 0;
        $denda_harian = 0;

        if ($absensi) {
            // Bonus jika target harian tercapai
            if ($request->capaian_harian >= $target_harian) {
                $bonus_harian = $gaji_harian * 0.1; // 10% dari gaji harian
            }
            
            // Denda jika tidak mencapai target
            if ($request->jumlah_pekerjaan < $target_harian) {
                $denda_harian = ($target_harian - $request->jumlah_pekerjaan) * 5000; // Denda 5000 per kekurangan pekerjaan
            }
        }

        $gaji_harian_obj = new GajiHarian();
        $gaji_harian_obj->id_karyawan = $request->id_karyawan;
        $gaji_harian_obj->tanggal = $request->tanggal;
        $gaji_harian_obj->id_pekerjaan = $request->id_pekerjaan;
        $gaji_harian_obj->jumlah_pekerjaan = $request->jumlah_pekerjaan;
        $gaji_harian_obj->target_harian = $target_harian;
        $gaji_harian_obj->capaian_harian = $request->capaian_harian;
        $gaji_harian_obj->gaji_harian = $gaji_harian;
        $gaji_harian_obj->bonus_harian = $bonus_harian;
        $gaji_harian_obj->denda_harian = $denda_harian;
        $gaji_harian_obj->status_pengambilan = 0;
        $gaji_harian_obj->save();

        return redirect()->route('gaji_harian.index')->with('success', 'Gaji harian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gaji_harian = GajiHarian::findOrFail($id);
        $karyawan = Karyawan::all();
        $pekerjaan = Pekerjaan::all();
        return view('gaji_harian.edit', compact('gaji_harian', 'karyawan', 'pekerjaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'tanggal' => 'required|date',
            'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
            'jumlah_pekerjaan' => 'required|numeric',
            'target_harian' => 'required|numeric',
            'capaian_harian' => 'required|numeric',
            'status_pengambilan' => 'required|boolean',
        ]);

        $gaji_harian = GajiHarian::findOrFail($id);
        $pekerjaan = Pekerjaan::find($request->id_pekerjaan);
        $gaji_harian_rate = $pekerjaan->gaji;
        $target_harian = $pekerjaan->target;

        // Menghitung bonus dan denda berdasarkan absensi
        $absensi = Absensi::where('id_karyawan', $request->id_karyawan)
                           ->whereDate('tanggal', $request->tanggal)
                           ->first();

        $bonus_harian = 0;
        $denda_harian = 0;

        if ($absensi) {
            // Bonus jika target harian tercapai
            if ($request->capaian_harian >= $target_harian) {
                $bonus_harian = $gaji_harian_rate * 0.1; // 10% dari gaji harian
            }
            
            // Denda jika tidak mencapai target
            if ($request->jumlah_pekerjaan < $target_harian) {
                $denda_harian = ($target_harian - $request->jumlah_pekerjaan) * 5000; // Denda 5000 per kekurangan pekerjaan
            }
        }

        $gaji_harian->id_karyawan = $request->id_karyawan;
        $gaji_harian->tanggal = $request->tanggal;
        $gaji_harian->id_pekerjaan = $request->id_pekerjaan;
        $gaji_harian->jumlah_pekerjaan = $request->jumlah_pekerjaan;
        $gaji_harian->target_harian = $target_harian;
        $gaji_harian->capaian_harian = $request->capaian_harian;
        $gaji_harian->gaji_harian = $gaji_harian_rate;
        $gaji_harian->bonus_harian = $bonus_harian;
        $gaji_harian->denda_harian = $denda_harian;
        $gaji_harian->status_pengambilan = $request->status_pengambilan;
        $gaji_harian->save();

        return redirect()->route('gaji_harian.index')->with('success', 'Gaji harian berhasil diperbarui.');
    }

    public function ambilGaji($id)
    {
        $gaji_harian = GajiHarian::findOrFail($id);

        if ($gaji_harian->status_pengambilan) {
            return redirect()->back()->with('error', 'Gaji sudah diambil.');
        }

        $gaji_harian->status_pengambilan = 1;
        $gaji_harian->save();

        return redirect()->route('gaji_harian.index')->with('success', 'Gaji berhasil diambil.');
    }

    public function cetakSlipGaji($id)
    {
        $gaji_harian = GajiHarian::with('karyawan', 'pekerjaan')->findOrFail($id);

        // Setup Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Render view into PDF
        $html = view('gaji_harian.slip_gaji', compact('gaji_harian'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Download PDF
        return $dompdf->stream('slip_gaji_'.$gaji_harian->id_gaji_harian.'.pdf');
    }
    public function destroy($id)
{
    $gajiHarian = GajiHarian::find($id);

    if ($gajiHarian) {
        $gajiHarian->delete();
        return redirect()->route('gaji_harian.index')->with('success', 'Data gaji harian berhasil dihapus.');
    } else {
        return redirect()->route('gaji_harian.index')->with('error', 'Data gaji harian tidak ditemukan.');
    }
}
}
