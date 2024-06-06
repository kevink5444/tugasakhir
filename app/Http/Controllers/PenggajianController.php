<?php
namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Penggajian;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        // Load relasi karyawan
        $penggajian = Penggajian::with('karyawan')->get();

        // Debugging untuk memeriksa data
        // dd($penggajian);

        return view('penggajian.index', compact('penggajian'));
    }

    public function edit($penggajian)
    {
        // Menggunakan findOrFail untuk memastikan $penggajian ditemukan berdasarkan id
        $penggajian = Penggajian::findOrFail($penggajian);
        $karyawan = Karyawan::all();
        return view('penggajian.edit', compact('penggajian', 'karyawan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'gaji_pokok' => 'required|numeric',
            'bonus' => 'required|numeric',
            'denda' => 'required|numeric',
            'total_gaji' => 'required|numeric',
        ]);

        // Validasi $id untuk memastikan bahwa itu adalah angka yang valid
        if (!is_numeric($id)) {
            abort(404); // Atau tangani sesuai kebutuhan aplikasi Anda
        }

        try {
            $penggajian = Penggajian::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404); // Atau tangani sesuai kebutuhan aplikasi Anda
        }

        $penggajian->id_karyawan = $request->input('id_karyawan');
        $penggajian->gaji_pokok = $request->input('gaji_pokok');
        $penggajian->bonus = $request->input('bonus');
        $penggajian->denda = $request->input('denda');
        $penggajian->total_gaji = $request->input('total_gaji');
        $penggajian->save();

        return redirect()->route('penggajian.index')->with('success', 'Data gaji berhasil diperbarui.');
    }
}
