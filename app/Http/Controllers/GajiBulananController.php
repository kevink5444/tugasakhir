<?php

namespace App\Http\Controllers;

use App\Models\GajiBulanan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use App\Models\Absensi;
use App\Models\Lembur;

class GajiBulananController extends Controller
{
    // Menampilkan daftar gaji bulanan
    public function index()
    {
        $gajiBulanan = GajiBulanan::with('karyawan')->get();
        return view('gaji_bulanan.index', compact('gajiBulanan'));
    }

    // Menampilkan form untuk menambah gaji bulanan
    public function create()
    {
        $karyawans = Karyawan::all();
        return view('gaji_bulanan.create', compact('karyawans'));
    }

    // Proses penyimpanan data gaji bulanan ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'bulan' => 'required|date_format:Y-m',
        ]);
        
        // Menggabungkan bulan dengan tanggal pertama untuk keperluan penyimpanan
        $bulan = $request->bulan . '-01';
        $karyawan = Karyawan::find($request->id_karyawan);
        $posisi = $karyawan->posisi;

        // Hitung gaji pokok berdasarkan posisi karyawan
        $gajiPokok = $this->getGajiPokokByPosisi($posisi);

        // Uang transport dan makan
        $uangTransport = 350000;
        $uangMakan = 300000;

        // Menyimpan data gaji bulanan ke database
        GajiBulanan::create([
            'id_karyawan' => $request->id_karyawan,
            'bulan' => $bulan,
            'gaji_pokok' => $gajiPokok,
            'uang_transport' => $uangTransport,
            'uang_makan' => $uangMakan,
            'bonus' => 0,
            'thr' => 0,
            'total_gaji' => $gajiPokok + $uangTransport + $uangMakan,
            'total_lembur' => 0,
            'bonus_lembur' => 0,
            'denda' => 0,
            'status_pengambilan' => false,
        ]);

        return redirect()->route('gaji_bulanan.index');
    }

    // Metode untuk menentukan gaji pokok berdasarkan posisi karyawan
    private function getGajiPokokByPosisi($posisi)
    {
        switch ($posisi) {
            case 'Karyawan Administrasi':
                return 3000000;
            case 'Sopir':
                return 2500000;
            case 'Supervisor Produksi':
                return 3000000;
            case 'Manager Produksi':
                return 4000000;
            case 'Karyawan Quality Control':
                return 4500000;
            default:
                return 0; // Nilai default jika posisi tidak ditemukan
        }
    }

    // Mengedit data gaji bulanan
    public function edit(GajiBulanan $gajiBulanan)
    {
        return view('gaji_bulanan.edit', compact('gajiBulanan'));
    }

    // Mengupdate data gaji bulanan
    public function update(Request $request, GajiBulanan $gajiBulanan)
    {
        $gajiBulanan->update($request->all());
        return redirect()->route('gaji_bulanan.index');
    }

    // Menghapus data gaji bulanan
    public function destroy(GajiBulanan $gajiBulanan)
    {
        $gajiBulanan->delete();
        return redirect()->route('gaji_bulanan.index');
    }

    // Memproses pengambilan gaji oleh karyawan
    public function ambilGaji(GajiBulanan $gajiBulanan)
    {
        if ($gajiBulanan->status_pengambilan) {
            return redirect()->back()->with('error', 'Gaji sudah diambil bulan ini.');
        }

        $gajiBulanan->update(['status_pengambilan' => true]);
        return redirect()->back()->with('success', 'Gaji berhasil diambil.');
    }
    public function filter(Request $request)
{
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

    // Ambil data gaji bulanan berdasarkan filter bulan dan tahun
    $gajiBulanan = GajiBulanan::with('karyawan')
        ->when($bulan, function ($query, $bulan) {
            $query->whereMonth('bulan', $bulan);
        })
        ->when($tahun, function ($query, $tahun) {
            $query->whereYear('bulan', $tahun);
        })
        ->get();

    return view('gaji_bulanan.index', compact('gajiBulanan', 'bulan', 'tahun'));
}
    // Mencetak slip gaji bulanan dalam bentuk PDF
    public function slipGaji(GajiBulanan $gajiBulanan)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);

        $html = view('gaji_bulanan.slip_gaji', compact('gajiBulanan'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('slip_gaji_' . $gajiBulanan->id . '.pdf');
    }

    // Menghitung total gaji bulanan dengan menghitung lembur, bonus, denda, dll
    public function calculateGajiBulanan($id_karyawan, $bulan, $tahun)
    {
        // Ambil data absensi dan lembur berdasarkan bulan dan tahun
        $absensi = Absensi::where('id_karyawan', $id_karyawan)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $total_denda = $absensi->sum('denda');
        $total_bonus = $absensi->sum('bonus');

        $lembur = Lembur::where('id_karyawan', $id_karyawan)
            ->whereMonth('tanggal_lembur', $bulan)
            ->whereYear('tanggal_lembur', $tahun)
            ->where('status_lembur', 'Disetujui')
            ->sum('bonus_lembur');

        // Cari data gaji bulanan yang sesuai
        $gaji_bulanan = GajiBulanan::where('id_karyawan', $id_karyawan)
            ->whereMonth('bulan', $bulan)
            ->whereYear('bulan', $tahun)
            ->first();

        // Jika data gaji bulanan ditemukan, hitung total gaji
        if ($gaji_bulanan) {
            $gaji_bulanan->total_gaji = $gaji_bulanan->gaji_pokok + $gaji_bulanan->uang_transport + $gaji_bulanan->uang_makan + $gaji_bulanan->bonus + $total_bonus + $lembur - $total_denda;
            $gaji_bulanan->save();
        }
    }
}
