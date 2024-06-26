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
            'id_karyawan' => 'required|unique:karyawan,id_karyawan',
            'nama_karyawan' => 'required',
            'alamat_karyawan' => 'required',
            'email_karyawan' => 'required|email|unique:karyawan,email_karyawan',
            'status_karyawan' => 'required|in:Borongan,Harian,Tetap',
        ]);

        // Simpan data karyawan baru
        $karyawan = new Karyawan();
        $karyawan->id_karyawan = $request->id_karyawan;
        $karyawan->nama_karyawan = $request->nama_karyawan;
        $karyawan->alamat_karyawan = $request->alamat_karyawan;
        $karyawan->email_karyawan = $request->email_karyawan;
        $karyawan->status_karyawan = $request->status_karyawan;
        $karyawan->save();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }
    public function show()
    {
        $karyawan = Karyawan::findOrFail();
        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Menampilkan formulir untuk mengedit karyawan yang ditentukan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $status = [
            'borongan' => 'Borongan',
            'harian' => 'Harian',
            'tetap' => 'Tetap',
        ];

        return view('karyawan.edit', compact('karyawan','status'));
    }
    
    public function update(Request $request, $id_karyawan)
{
    $karyawan = Karyawan::findOrFail($id_karyawan);

    $request->validate([
        'nama_karyawan' => 'required',
        'alamat_karyawan' => 'required',
        'status_karyawan' => 'required',
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
        // Hapus karyawan berdasarkan ID
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $karyawan->delete();
        return redirect()->route('karyawan.index')
                         ->with('success', 'Karyawan berhasil dihapus.');
        
       
    }
}