<?php
namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    public function index()
    {
        $pekerjaan = Pekerjaan::all();
        return view('pekerjaan.index', compact('pekerjaan'));
    }

    public function create()
    {
        return view('pekerjaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'target_harian' => 'required|integer',
            'gaji_per_pekerjaan'=> 'required|numeric',
        ]);

        Pekerjaan::create($request->all());
        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil ditambahkan.');
    }

    public function edit($id_pekerjaan)
    {
        $pekerjaan = Pekerjaan::findOrFail($id_pekerjaan);
        return view('pekerjaan.edit', compact('pekerjaan'));
    }

    public function update(Request $request, $id_pekerjaan)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'target_harian' => 'required|integer',
            'gaji_per_pekerjaan'=> 'required|numeric',
        ]);

        $pekerjaan = Pekerjaan::findOrFail($id_pekerjaan);
        $pekerjaan->update($request->all());
        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil diperbarui.');
    }

    public function destroy($id_pekerjaan)
    {
        $pekerjaan = Pekerjaan::findOrFail($id_pekerjaan);
        $pekerjaan->delete();
        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil dihapus.');
    }
}