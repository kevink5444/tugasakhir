<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with('karyawan')->get();
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        return view('karyawan.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'alamat_karyawan' => 'required|string|max:100',
            'email_karyawan' => 'required|email|unique:karyawan,email_karyawan',
            'status_karyawan' => 'required|in:Borongan,Harian,Tetap',
            'pekerjaan' => 'required|string|max:255',
            'target_borongan' => 'required|integer|min:0',
            'target_harian' => 'required|integer|min:0',
        ]);

        // Simpan data karyawan baru
        Karyawan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'alamat_karyawan' => $request->alamat_karyawan,
            'email_karyawan' => $request->email_karyawan,
            'status_karyawan' => $request->status_karyawan,
            'pekerjaan' => $request->pekerjaan,
            'target_borongan' => $request->target_borongan,
            'target_harian' => $request->target_harian,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $status = [
            'Borongan' => 'Borongan',
            'Harian' => 'Harian',
            'Tetap' => 'Tetap',
        ];

        return view('karyawan.edit', compact('karyawan', 'status'));
    }

    public function update(Request $request, $id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);

        
            $request->validate([
                'nama_karyawan' => 'required|string|max:255',
                'alamat_karyawan' => 'required|string|max:100',
                'status_karyawan' => 'required|in:Borongan,Harian,Tetap',
            ]);
        
            $karyawan->update([
                'nama_karyawan' => $request->nama_karyawan,
                'alamat_karyawan' => $request->alamat_karyawan,
                'status_karyawan' => $request->status_karyawan,
            ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}