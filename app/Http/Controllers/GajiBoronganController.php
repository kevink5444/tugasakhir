<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GajiBorongan;
use App\Models\Karyawan;
use App\Models\Absensi;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
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
        'minggu_mulai' => 'required|date',
        'minggu_selesai' => 'required|date|after:minggu_mulai',
        'pekerjaan' => 'required|string',
        'total_pekerjaan' => 'required|numeric',
        'total_lembur' => 'required|numeric',
        'bonus_lembur' => 'required|numeric',
    ]);

    $total_gaji_borongan = $this->calculateTotalGaji($request->id_karyawan, $request->pekerjaan, $request->total_pekerjaan);
    $total_bonus = $this->calculateTotalBonus($request->id_karyawan, $request->minggu_mulai, $request->minggu_selesai);
    $total_denda = $this->calculateTotalDenda($request->id_karyawan, $request->minggu_mulai, $request->minggu_selesai);

    $gaji_borongan = new GajiBorongan();
    $gaji_borongan->id_karyawan = $request->id_karyawan;
    $gaji_borongan->minggu_mulai = $request->minggu_mulai;
    $gaji_borongan->minggu_selesai = $request->minggu_selesai;
    $gaji_borongan->total_gaji_borongan = $total_gaji_borongan;
    $gaji_borongan->total_bonus = $total_bonus;
    $gaji_borongan->total_denda = $total_denda;
    $gaji_borongan->total_pekerjaan = json_encode([$request->pekerjaan => $request->total_pekerjaan]);
    $gaji_borongan->total_lembur = $request->total_lembur;
    $gaji_borongan->bonus_lembur = $request->bonus_lembur;
    $gaji_borongan->status_pengambilan = 0;
    $gaji_borongan->save();

        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil ditambahkan.');
    }

    private function calculateTotalGaji($pekerjaan, $total_pekerjaan)
    {$total_gaji = 0;
        $gaji_per_item = [
            'kancing' => 1200,
            'lubang' => 1300,
            'obras_baju' => 1900,
            'obras_tangan' => 1500,
            'obras_lengan' => 1200,
        ];

        if (array_key_exists($pekerjaan, $gaji_per_item)) {
            $total_gaji = $total_pekerjaan * $gaji_per_item[$pekerjaan];
        }

        return $total_gaji;
    }

    private function calculateTotalBonus($id_karyawan, $minggu_mulai, $minggu_selesai)
    {
        $total_bonus = 0;
        $absensi = Absensi::where('id_karyawan', $id_karyawan)
                            ->whereBetween('tanggal', [$minggu_mulai, $minggu_selesai])
                            ->get();

        foreach ($absensi as $absen) {
            $jam_masuk = new Carbon($absen->jam_masuk);
            if ($jam_masuk->hour < 8 || ($jam_masuk->hour == 8 && $jam_masuk->minute <= 0)) {
                $total_bonus += 25000; // Bonus Rp 25.000 untuk datang tepat waktu atau lebih awal
            }
        }

        return $total_bonus;
    }

    private function calculateTotalDenda($id_karyawan, $minggu_mulai, $minggu_selesai)
    {
        $total_denda = 0;
        $absensi = Absensi::where('id_karyawan', $id_karyawan)
                            ->whereBetween('tanggal', [$minggu_mulai, $minggu_selesai])
                            ->get();

        foreach ($absensi as $absen) {
            $jam_masuk = new Carbon($absen->jam_masuk);
            if ($jam_masuk->hour > 8 || ($jam_masuk->hour == 8 && $jam_masuk->minute > 5)) {
                $total_denda += 10000; // Denda Rp 10.000 untuk keterlambatan lebih dari 5 menit
            }
        }

        return $total_denda;
    }

    public function edit($id_karyawan)
    {
        $gaji_borongan = GajiBorongan::findOrFail($id_karyawan);
        $karyawan = Karyawan::all();
        
        // Ubah $total_pekerjaan menjadi format yang sesuai
        $total_pekerjaan = json_decode($gaji_borongan->total_pekerjaan, true);
        
        return view('gaji_borongan.edit', compact('gaji_borongan', 'karyawan', 'total_pekerjaan'));
    }


    
    public function update(Request $request, $id_karyawan)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'minggu_mulai' => 'required|date',
            'minggu_selesai' => 'required|date|after:minggu_mulai',
            'total_pekerjaan' => 'required|array',
            'total_pekerjaan.*' => 'required|numeric',
            'total_lembur' => 'required|numeric',
            'bonus_lembur' => 'required|numeric',
            'status_pengambilan' => 'required|boolean',
        ]);
    
        $gaji_borongan = GajiBorongan::findOrFail($id_karyawan);
        $total_gaji_borongan = $this->calculateTotalGaji($request->id_karyawan, $request->total_pekerjaan);
        $total_bonus = $this->calculateTotalBonus($request->id_karyawan, $request->minggu_mulai, $request->minggu_selesai);
        $total_denda = $this->calculateTotalDenda($request->id_karyawan, $request->minggu_mulai, $request->minggu_selesai);
    
        $gaji_borongan->update([
            'id_karyawan' => $request->id_karyawan,
            'minggu_mulai' => $request->minggu_mulai,
            'minggu_selesai' => $request->minggu_selesai,
            'total_gaji_borongan' => $total_gaji_borongan,
            'total_bonus' => $total_bonus,
            'total_denda' => $total_denda,
            'total_pekerjaan' => json_encode($request->total_pekerjaan), // Encode array to JSON
            'total_lembur' => $request->total_lembur,
            'bonus_lembur' => $request->bonus_lembur,
            'status_pengambilan' => $request->status_pengambilan,
        ]);
    
        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil diperbarui.');
    }

    public function destroy($id_karyawan)
    {
        $gaji_borongan = GajiBorongan::findOrFail($id_karyawan);
        $gaji_borongan->delete();

        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji borongan berhasil dihapus.');
    }

    public function cetakSlipGaji($id_gaji_borongan)
{
    $gaji = GajiBorongan::with('karyawan')->findOrFail($id_gaji_borongan);
    return view('gaji_borongan.slip_gaji', compact('gaji'));
}

    public function ambilGaji($id)
    {
        $gaji_borongan = GajiBorongan::findOrFail($id);
        if ($gaji_borongan->status_pengambilan) {
            return redirect()->back()->with('error', 'Gaji sudah diambil.');
        }

        $gaji_borongan->status_pengambilan = 1;
        $gaji_borongan->save();

        return redirect()->route('gaji_borongan.index')->with('success', 'Gaji berhasil diambil.');
    }
    public function downloadPdf($id)
    {
        // Fetch the gaji borongan record based on the ID
        $gaji = GajiBorongan::findOrFail($id);

        // Load the view and pass the data to it
        $pdf = PDF::loadView('gaji_borongan.slip_gaji', compact('gaji'));

        // Return the PDF download response
        return $pdf->download('Slip_Gaji_Borongan_' . $gaji->id_gaji_borongan . '.pdf');

        return redirect()->route('gaji_borongan.index')->with('success', 'Slip Gaji berhasil diunduh.');
    
    }
    
}
