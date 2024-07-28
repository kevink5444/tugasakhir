<?php
namespace App\Http\Controllers;

use App\Models\Capaian;
use App\Models\Karyawan;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class CapaianController extends Controller
{
    public function index()
    {
        $capaian = Capaian::with('karyawan', 'pekerjaan')->get();
        return view('capaian.index', compact('capaian'));
    }

    public function create()
    {
        $karyawan = Karyawan::all();
        $pekerjaan = Pekerjaan::all();
        
        return view('capaian.create', compact('karyawan', 'pekerjaan'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_karyawan' => 'required|integer',
            'id_pekerjaan' => 'required|integer',
            'jumlah_capaian' => 'required|integer',
        ]);

        try {
            // Simpan data capaian baru
            Capaian::create([
                'id_karyawan' => $request->id_karyawan,
                'id_pekerjaan' => $request->id_pekerjaan,
                'jumlah_capaian' => $request->jumlah_capaian,
            ]);

            // Redirect ke halaman yang diinginkan dengan pesan sukses
            return redirect()->route('capaian.index')->with('success', 'Capaian berhasil ditambahkan.');

        } catch (\Exception $e) {
            // Tangani kesalahan dan tampilkan pesan
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }
}
