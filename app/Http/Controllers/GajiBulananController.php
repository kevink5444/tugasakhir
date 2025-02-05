<?php

namespace App\Http\Controllers;

use App\Models\GajiBulanan;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Lembur;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        
        $bulan = $request->bulan . '-01';
        $karyawan = Karyawan::find($request->id_karyawan);
        $posisi = $karyawan->posisi;

        // Hitung gaji pokok berdasarkan posisi
        $gajiPokok = $this->getGajiPokokByPosisi($posisi);

        // Perhitungan otomatis
        $uangTransport = 350000; // Contoh fixed value
        $uangMakan = 300000; // Contoh fixed value
        $bonus = $this->calculateBonus($karyawan->id_karyawan, $request->bulan);
        $thr = $gajiPokok / 12; // THR biasanya sebulan gaji dibagi 12 bulan
        $denda = $this->calculateDenda($karyawan->id_karyawan, $request->bulan);
        $totalLembur = $this->calculateLembur($karyawan->id_karyawan, $request->bulan);

        // Hitung total gaji
        $totalGaji = $gajiPokok + $uangTransport + $uangMakan + $bonus + $thr + $totalLembur - $denda;

        // Simpan data ke database
        GajiBulanan::create([
            'id_karyawan' => $request->id_karyawan,
            'bulan' => $bulan,
            'gaji_pokok' => $gajiPokok,
            'uang_transport' => $uangTransport,
            'uang_makan' => $uangMakan,
            'bonus' => $bonus,
            'thr' => $thr,
            'total_gaji' => $totalGaji,
            'total_lembur' => $totalLembur,
            'bonus_lembur' => $totalLembur, // Menganggap lembur dihitung sebagai bonus
            'denda' => $denda,
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

    // Menghitung bonus berdasarkan data absensi
    private function calculateBonus($id_karyawan, $bulan)
    {
        $absensi = Absensi::where('id_karyawan', $id_karyawan)
            ->whereMonth('tanggal', date('m', strtotime($bulan)))
            ->whereYear('tanggal', date('Y', strtotime($bulan)))
            ->get();

        return $absensi->sum('bonus'); // Bonus dari absensi
    }

    // Menghitung denda berdasarkan data absensi
    private function calculateDenda($id_karyawan, $bulan)
    {
        $absensi = Absensi::where('id_karyawan', $id_karyawan)
            ->whereMonth('tanggal', date('m', strtotime($bulan)))
            ->whereYear('tanggal', date('Y', strtotime($bulan)))
            ->get();

        return $absensi->sum('denda'); // Denda dari absensi
    }

    // Menghitung lembur
    private function calculateLembur($id_karyawan, $bulan)
    {
        return Lembur::where('id_karyawan', $id_karyawan)
            ->whereMonth('tanggal_lembur', date('m', strtotime($bulan)))
            ->whereYear('tanggal_lembur', date('Y', strtotime($bulan)))
            ->where('status_lembur', 'Disetujui')
            ->sum('bonus_lembur'); // Total lembur
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
    public function filter(Request $request)
    {
        $bulan = $request->input('bulan'); // contoh: 8
        $tahun = $request->input('tahun'); // contoh: 2024

        // Cek apakah bulan & tahun dikirimkan
        if (empty($bulan) || empty($tahun)) {
            return redirect()->route('gaji_bulanan.index')->with('error', 'Bulan dan tahun harus diisi!');
        }

        // Filter berdasarkan kolom 'bulan' dengan format 'YYYY-MM'
        $gajiBulanan = GajiBulanan::whereRaw("DATE_FORMAT(bulan, '%Y-%m') = ?", ["$tahun-$bulan"])
                                  ->get();

        return view('gaji_bulanan.index', compact('gajiBulanan'));
    }

    // Menghapus data gaji bulanan
    public function destroy(GajiBulanan $gajiBulanan)
    {
        $gajiBulanan->delete();
        return redirect()->route('gaji_bulanan.index');
    }
    
}
