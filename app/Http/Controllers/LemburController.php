<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembur;

class LemburController extends Controller
{
    public function approveLembur($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->status_lembur = 'Disetujui';
        $lembur->save();

        return redirect()->back()->with('success', 'Lembur telah disetujui.');
    }

    public function rejectLembur($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->status_lembur = 'Ditolak';
        $lembur->save();

        return redirect()->back()->with('success', 'Lembur telah ditolak.');
    }
}