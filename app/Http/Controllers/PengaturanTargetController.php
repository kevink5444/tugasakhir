<?php
namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\PengaturanTarget;
use Illuminate\Http\Request;

class PengaturanTargetController extends Controller
{
    public function index()
    {
        $targets = PengaturanTarget::all();
        return view('pengaturan_target.index', compact('targets'));
    }

    public function create()
    {
        $pekerjaans = Pekerjaan::all();
        return view('pengaturan_target.create', compact('pekerjaans'));
    
    }

    public function store(Request $request)
    {
        $request->validate([
            'pekerjaan' => 'required|string|max:255',
            'target_mingguan' => 'required|integer',
            'target_borongan' => 'required|integer',
            'target_harian' => 'required|integer',
        ]);

        PengaturanTarget::create($request->all());
        return redirect()->route('pengaturan_target.index')->with('success', 'Target berhasil ditambahkan');
    }

    public function edit($id)
    {
        $target = PengaturanTarget::find($id);
        return view('pengaturan_target.edit', compact('target'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pekerjaan' => 'required|string|max:255',
            'target_mingguan' => 'required|integer',
            'target_borongan' => 'required|integer',
            'target_harian' => 'required|integer',
        ]);

        $target = PengaturanTarget::find($id);
        $target->update($request->all());
        return redirect()->route('pengaturan_target.index')->with('success', 'Target berhasil diupdate');
    }

    public function destroy($id)
    {
        $target = PengaturanTarget::find($id);
        $target->delete();
        return redirect()->route('pengaturan_target.index')->with('success', 'Target berhasil dihapus');
    }
}