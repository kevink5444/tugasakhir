<?php
namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Penggajian;
use Illuminate\Http\Request;
class PenggajianController extends Controller
{
    public function index()
    {
       
        $penggajian = Penggajian::with(['karyawan' => function($query) {
            $query->withTrashed();
        }])->get();
      

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


    public function update(Request $request, $id_penggajian)
    {
        try {
            $penggajian = Penggajian::findOrFail($id_penggajian);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Penggajian tidak ditemukan.');
        }
    
        $request->validate([
            'gaji_pokok' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'denda' => 'nullable|numeric',
            'total_gaji' => 'required|numeric',
        ]);
    
        $penggajian->fill([
            'gaji_pokok' => $request->gaji_pokok,
            'bonus' => $request->bonus,
            'denda' => $request->denda,
            'total_gaji' => $request->total_gaji,
        ]);
    
        $penggajian->save();
    
        return redirect()->route('penggajian')->with('success', 'Data gaji berhasil diperbarui.');
    }
    
    
    public function delete($id_penggajian)
    {
        $penggajian = Penggajian::findOrFail($id_penggajian);
        $penggajian->delete();

        return redirect()->route('penggajian')->with('success', 'Data penggajian berhasil dihapus.');
    }
}
