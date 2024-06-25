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
    public function create()
    {
        $karyawans = Karyawan::all();
        
        return view('penggajian.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'gaji_pokok' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        Penggajian::create([
            'id_karyawan' => $request->id_karyawan,
            'gaji_pokok' => $request->gaji_pokok,
            'total_gaji' => $request->gaji_pokok,
        ]);

        return redirect()->route('penggajian')->with('success', 'Penggajian berhasil ditambahkan.');
    }    

    public function edit($id_penggajian)
    {
        $penggajian = Penggajian::findOrFail($id_penggajian);
        $karyawans = Karyawan::all();
        return view('penggajian.edit', compact('penggajian', 'karyawans'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
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

        // Mengupdate data penggajian
        $penggajian->id_karyawan = $request->input('id_karyawan');
        $penggajian->gaji_pokok = $request->input('gaji_pokok');
        $penggajian->bonus = $request->input('bonus');
        $penggajian->denda = $request->input('denda');
        
        // Menghitung total gaji jika tidak ingin menghitung dari input total_gaji
        // $penggajian->total_gaji = $penggajian->gaji_pokok + $penggajian->bonus - $penggajian->denda;
        
        // Menggunakan input total_gaji dari form
        $penggajian->total_gaji = $request->input('total_gaji');
        
        $penggajian->save();

        return redirect()->route('penggajian.index')->with('success', 'Data gaji berhasil diperbarui.');
    }
    public function destroy($id_penggajian)
    {
        $penggajian = Penggajian::findOrFail($id_penggajian);
        $penggajian->delete();

        return redirect()->route('penggajian.index')->with('success', 'Data penggajian berhasil dihapus.');
    }
}
