<?php
namespace App\Http\Controllers;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Penggajian;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajian = Penggajian::with('karyawan')->get();
        return view('penggajian.index', compact('penggajian'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        return view('penggajian.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'gaji_pokok' => 'required|numeric',
            'bonus_pekerjaan' => 'nullable|numeric',
            'denda' => 'nullable|numeric'
        ]);

        $karyawan = Karyawan::find($request->id_karyawan);
        $capaian = $this->calculateCapaian($karyawan->id_karyawan); // Metode untuk menghitung capaian
        $status_karyawan = $karyawan->status_karyawan;
        $bonus = 0;
        $denda = 0;
        $total_gaji = $request->gaji_pokok;
        $lembur = $karyawan->hitungLembur($request->id_karyawan);

        // Logika perhitungan bonus dan denda
        if ($status_karyawan == 'borongan') {
            $target = 300; // Misal target untuk karyawan borongan
            if ($capaian >= $target) {
                $bonus = ($capaian - $target) * 0.1;
            } else {
                $denda = ($target - $capaian) * 0.05;
            }
            $total_gaji += $bonus - $denda;
        }

        Penggajian::create([
            'id_karyawan' => $request->id_karyawan,
            'gaji_pokok' => $request->gaji_pokok,
            'bonus' => $bonus,
            'denda' => $denda,
            'total_gaji' => $total_gaji,
            'capaian' => $capaian,
            'status_karyawan' => $status_karyawan
        ]);

        return redirect()->route('penggajian.index')->with('success', 'Penggajian berhasil ditambahkan.');
    }

    private function calculateCapaian($id_karyawan)
    {
        // Logika untuk menghitung capaian karyawan berdasarkan data absensi atau kriteria lainnya
        // Contoh:
        $absensi = Absensi::where('email', Karyawan::find($id_karyawan)->email_karyawan)->count();
        return $absensi; // Misal capaian adalah jumlah absensi
    }

    public function edit($id_penggajian)
    {
        $penggajian = Penggajian::findOrFail($id_penggajian);
        $karyawans = Karyawan::all();
        return view('penggajian.edit', compact('penggajian', 'karyawans'));
    }

    public function update(Request $request, $id_penggajian)
    {
        $request->validate([
            'gaji_pokok' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'denda' => 'nullable|numeric',
            'total_gaji' => 'required|numeric',
        ]);
        $penggajian = Penggajian::findOrFail($id_penggajian);
        $lembur = $penggajian->hitungLembur($penggajian->id_karyawan);
        $penggajian->gaji_pokok = $request->gaji_pokok;
        $penggajian->bonus_absensi = $request->bonus_absensi;
        $penggajian->bonus_pekerjaan = $request->bonus_pekerjaan;
        $penggajian->denda = $request->denda;
        $penggajian->total_gaji = $request->total_gaji + $lembur;
        $penggajian->save();
        return redirect()->route('penggajian.index')->with('success', 'Data gaji berhasil diperbarui.');
    }

    public function delete($id_penggajian)
    {
        $penggajian = Penggajian::findOrFail($id_penggajian);
        $penggajian->delete();

        return redirect()->route('penggajian.index')->with('success', 'Data penggajian berhasil dihapus.');
    }
}