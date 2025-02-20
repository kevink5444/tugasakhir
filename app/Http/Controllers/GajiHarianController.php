<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GajiHarian;
use App\Models\Karyawan;
use App\Models\Pekerjaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GajiHarianController extends Controller
{
    
    public function index(Request $request)
    {
        
        $gajiHarian = GajiHarian::with('karyawan', 'pekerjaan')->get();
        return view('gaji_harian.index', compact('gajiHarian'));
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
        'tanggal_awal' => 'required|date',
        'tanggal_akhir' => 'required|date',
        'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
        'jumlah_pekerjaan' => 'required|numeric',
        'capaian_harian' => 'required|numeric',
    ]);

    $pekerjaan = Pekerjaan::find($request->id_pekerjaan);
    $gaji_per_unit = $pekerjaan->gaji_per_unit;
    $target_harian = $pekerjaan->target_harian;

    $tanggal_awal = Carbon::parse($request->tanggal_awal);
    $tanggal_akhir = Carbon::parse($request->tanggal_akhir);
    $totalHari = $tanggal_awal->diffInDays($tanggal_akhir) + 1;

    $totalGaji = 0;
    $totalBonus = 0;
    $totalDenda = 0;

    for ($i = 0; $i < $totalHari; $i++) {
        $tanggal = $tanggal_awal->copy()->addDays($i)->toDateString();

        $dataGajiPerHari = GajiHarian::where('id_karyawan', $request->id_karyawan)
            ->where('tanggal_awal', '<=', $tanggal)
            ->where('tanggal_akhir', '>=', $tanggal)
            ->first();

        if (!$dataGajiPerHari) {
            continue;
        }

        $jumlah_pekerjaan = $dataGajiPerHari->jumlah_pekerjaan;
        $capaian_harian = $dataGajiPerHari->capaian_harian;

        // Hitung gaji harian
        $gaji_harian = $capaian_harian * $gaji_per_unit;

        // Hitung bonus harian jika capaian memenuhi target
        $bonus_harian = ($capaian_harian >= $target_harian) ? $gaji_harian * 0.2 : 0;

        // Hitung denda harian jika capaian tidak memenuhi target
        $denda_harian = ($capaian_harian < $target_harian) ? $gaji_harian * 0.05 : 0;

        // Tambahkan ke total
        $totalGaji += $gaji_harian;
        $totalBonus += $bonus_harian;
        $totalDenda += $denda_harian;
    }

    // Simpan data gaji harian ke database
    $gaji_harian_obj = new GajiHarian();
    $gaji_harian_obj->id_karyawan = $request->id_karyawan;
    $gaji_harian_obj->tanggal_awal = $request->tanggal_awal;
    $gaji_harian_obj->tanggal_akhir = $request->tanggal_akhir;
    $gaji_harian_obj->id_pekerjaan = $request->id_pekerjaan;
    $gaji_harian_obj->jumlah_pekerjaan = $request->jumlah_pekerjaan; // Total jumlah pekerjaan
    $gaji_harian_obj->target_harian = $target_harian;
    $gaji_harian_obj->capaian_harian = $request->capaian_harian; // Total capaian
    $gaji_harian_obj->gaji_harian = $totalGaji;
    $gaji_harian_obj->bonus_harian = $totalBonus;
    $gaji_harian_obj->denda_harian = $totalDenda;
    $gaji_harian_obj->total_gaji_harian = $totalGaji + $totalBonus - $totalDenda;
    $gaji_harian_obj->status_pengambilan = 0; // Belum diambil
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
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan',
            'jumlah_pekerjaan' => 'required|numeric',
            'capaian_harian' => 'required|numeric',
            'status_pengambilan' => 'required|boolean',
        ]);

        $gaji_harian = GajiHarian::findOrFail($id);
        $pekerjaan = Pekerjaan::find($request->id_pekerjaan);
        $gaji_per_pekerjaan = $pekerjaan->gaji_per_pekerjaan;
        $target_harian = $pekerjaan->target_harian;

        $gaji_harian_rate = $gaji_per_unit;

        $bonus_harian = 0;
        $denda_harian = 0;

        if ($request->capaian_harian >= $target_harian) {
            $bonus_harian = $gaji_harian_rate * 0.2; // 20% dari gaji harian
        }

        if ($request->capaian_harian < $target_harian) {
            $denda_harian = $gaji_harian_rate * 0.05; // 5% dari gaji harian
        }

        $gaji_harian->id_karyawan = $request->id_karyawan;
        $gaji_harian->tanggal_awal = $request->tanggal_awal;
        $gaji_harian->tanggal_akhir = $request->tanggal_akhir;
        $gaji_harian->id_pekerjaan = $request->id_pekerjaan;
        $gaji_harian->jumlah_pekerjaan = $request->jumlah_pekerjaan;
        $gaji_harian->target_harian = $target_harian;
        $gaji_harian->capaian_harian = $request->capaian_harian;
        $gaji_harian->gaji_harian = $gaji_harian_rate;
        $gaji_harian->bonus_harian = $bonus_harian;
        $gaji_harian->denda_harian = $denda_harian;
        $gaji_harian->total_gaji_harian = $gaji_harian_rate + $bonus_harian - $denda_harian;
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

        return redirect()->route('gaji_harian.index')->with('success', 'Gaji harian berhasil diambil.');
    }

    public function cetakSlipGaji($id)
    {

        $gaji_harian = GajiHarian::findOrFail($id);
           
        $totalGajiPeriode = $gaji_harian->gaji_harian * 6; 

        return view('gaji_harian.slip_gaji', compact('gaji_harian', 'totalGajiPeriode'));
    
    return view('gaji_harian.slip_gaji', compact('gaji_harian', 'totalGaji'));

        $pdf = Pdf::loadView('gaji_harian.slip_gaji', compact('gaji_harian'));

        return $pdf->download('slip_gaji_' . $gaji_harian->id . '.pdf');
    }

    public function downloadPdf($id)
    {
        $gaji_harian = GajiHarian::findOrFail($id);

        $pdf = Pdf::loadView('gaji_harian.slip_gaji', compact('gaji_harian'));

        return $pdf->download('slip_gaji_' . $gaji_harian->id . '.pdf');
    }

    public function destroy($id)
    {
        $gaji_harian = GajiHarian::findOrFail($id);
        $gaji_harian->delete();
        return redirect()->route('gaji_harian.index')->with('success', 'Gaji harian berhasil dihapus.');
    }
    public function filter(Request $request)
{
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

    // Validasi input bulan dan tahun
    $request->validate([
        'bulan' => 'nullable|integer|between:1,12',
        'tahun' => 'nullable|integer|min:2000|max:' . date('Y'),
    ]);

    // Query data gaji harian dengan filter bulan dan tahun
    $gajiHarian = GajiHarian::with('karyawan', 'pekerjaan')
        ->when($bulan, function ($query, $bulan) {
            return $query->whereMonth('tanggal_awal', $bulan);
        })
        ->when($tahun, function ($query, $tahun) {
            return $query->whereYear('tanggal_awal', $tahun);
        })
        ->get();

    // Passing data filter ke view
    return view('gaji_harian.index', compact('gajiHarian', 'bulan', 'tahun'));
}
}
