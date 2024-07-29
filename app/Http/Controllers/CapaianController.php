<?php
// app/Http/Controllers/CapaianController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Capaian;
use App\Models\Karyawan;
use App\Models\Pekerjaan; // Pastikan Anda memiliki model Pekerjaan

class CapaianController extends Controller
{
    public function create()
    {
        $karyawan = Karyawan::all(); // Mengambil semua karyawan untuk dropdown
        $pekerjaan = Pekerjaan::all(); // Mengambil semua pekerjaan untuk dropdown
        return view('capaian.create', compact('karyawan', 'pekerjaan'));
    }

   // app/Http/Controllers/CapaianController.php

public function store(Request $request)
{
    $validated = $request->validate([
        'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        'id_pekerjaan' => 'required|exists:pekerjaan,id_pekerjaan', // Update field name
        'jumlah_capaian' => 'required|integer',
        'tanggal' => 'required|date',
    ]);

    Capaian::create([
        'id_karyawan' => $validated['id_karyawan'],
        'id_pekerjaan' => $validated['id_pekerjaan'], // Update field name
        'jumlah_capaian' => $validated['jumlah_capaian'],
        'tanggal' => $validated['tanggal'],
    ]);

    return redirect()->route('capaian.index')->with('success', 'Data capaian berhasil disimpan.');
}
    public function index()
    {
        $capaian = Capaian::all(); // Ambil semua data capaian
        return view('capaian.index', compact('capaian'));
    }
}