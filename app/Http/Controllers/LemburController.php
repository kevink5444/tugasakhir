<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembur;
use App\Models\GajiBorongan;
use App\Models\GajiHarian;
use App\Models\GajiBulanan;
use App\Models\Karyawan;

class LemburController extends Controller
{
    public function index()
    {
        $lembur = Lembur::with('karyawan')->paginate(10);
        return view('lembur.index', compact('lembur'));
    }

    public function create()
    {
        $karyawan = Karyawan::all();
        return view('lembur.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'tanggal_lembur' => 'required|date',
            'jam_lembur' => 'required|integer|min:1',
            'status_lembur' => 'required|string|in:Pending,Disetujui,Ditolak',
            'bonus_lembur' => 'nullable|numeric|min:0',
        ]);
    
        Lembur::create([
            'id_karyawan' => $request->id_karyawan,
            'tanggal_lembur' => $request->tanggal_lembur,
            'jam_lembur' => $request->jam_lembur,
            'status_lembur' => $request->status_lembur,
            'bonus_lembur' => $request->bonus_lembur ?? 0,
        ]);
    
        return redirect()->route('lembur.index')->with('status', 'Pengajuan lembur berhasil, menunggu persetujuan.');
    }

    public function show($id)
    {
        $lembur = Lembur::findOrFail($id);
        return view('lembur.show', compact('lembur'));
    }

    public function edit($id)
    {
        $lembur = Lembur::findOrFail($id);
        return view('lembur.edit', compact('lembur'));
    }

    public function update(Request $request, $id)
    {
        $lembur = Lembur::findOrFail($id);
        $request->validate([
            'status_lembur' => 'required|in:Disetujui,Ditolak',
        ]);
    
        $lembur->status_lembur = $request->status_lembur;
        if ($request->status_lembur === 'Disetujui') {
            $lembur->jam_lembur = now()->format('H:i:s');
            $karyawan = Karyawan::find($lembur->id_karyawan);
            $gaji_per_hari = $this->getGajiPerHari($karyawan);
            $lembur->bonus_lembur = $lembur->hitungBonusLembur($lembur->jam_lembur, $gaji_per_hari);
            $lembur->save();
            $this->updateGaji($karyawan, $lembur);
        }
        $lembur->save();
    
        return redirect()->route('lembur.index')->with('status', 'Pengajuan lembur berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->delete();

        return redirect()->route('lembur.index')->with('status', 'Pengajuan lembur berhasil dihapus.');
    }

    private function getGajiPerHari($karyawan)
    {
        switch ($karyawan->jenis_karyawan) {
            case 'borongan':
                $gajiBorongan = GajiBorongan::where('id_karyawan', $karyawan->id_karyawan)->first();
                return $gajiBorongan->total_gaji_borongan / 6;

            case 'harian':
                $gajiHarian = GajiHarian::where('id_karyawan', $karyawan->id_karyawan)->orderBy('tanggal', 'desc')->first();
                return $gajiHarian->gaji_harian;

            case 'bulanan':
                $gajiBulanan = GajiBulanan::where('id_karyawan', $karyawan->id_karyawan)->first();
                return $gajiBulanan->gaji_pokok / 26;

            default:
                return 0;
        }
    }

    private function updateGaji($karyawan, $lembur)
    {
        switch ($karyawan->jenis_karyawan) {
            case 'borongan':
                $gajiBorongan = GajiBorongan::where('id_karyawan', $lembur->id_karyawan)->first();
                if ($gajiBorongan) {
                    $gajiBorongan->total_lembur += 1;
                    $gajiBorongan->bonus_lembur += $lembur->bonus_lembur;
                    $gajiBorongan->save();
                }
                break;

            case 'harian':
                $gajiHarian = GajiHarian::where('id_karyawan', $lembur->id_karyawan)->orderBy('tanggal', 'desc')->first();
                if ($gajiHarian) {
                    $gajiHarian->bonus_lembur += $lembur->bonus_lembur;
                    $gajiHarian->save();
                }
                break;

            case 'bulanan':
                $gajiBulanan = GajiBulanan::where('id_karyawan', $lembur->id_karyawan)->first();
                if ($gajiBulanan) {
                    $gajiBulanan->total_lembur += 1;
                    $gajiBulanan->bonus_lembur += $lembur->bonus_lembur;
                    $gajiBulanan->save();
                }
                break;
        }
    }
}
