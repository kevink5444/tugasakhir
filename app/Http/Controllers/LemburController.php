<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembur;
use App\Models\GajiBorongan;
use App\Models\GajiHarian;
use App\Models\GajiBulanan;
use App\Models\Karyawan;
use Barryvdh\DomPDF\Facade\Pdf;

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
        ]);

        Lembur::create([
            'id_karyawan' => $request->id_karyawan,
            'tanggal_lembur' => $request->tanggal_lembur,
            'jam_lembur' => $request->jam_lembur,
            'status_lembur' => 'Pending',
        ]);

        return redirect()->route('lembur.index')->with('status', 'Pengajuan lembur berhasil diajukan, menunggu persetujuan.');
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
            $karyawan = Karyawan::find($lembur->id_karyawan);
            $gaji_per_hari = $this->getGajiPerHari($karyawan);
            $lembur->bonus_lembur = $this->hitungBonusLembur($lembur->jam_lembur, $gaji_per_hari);
            $this->updateGaji($karyawan, $lembur);
        }
        $lembur->save();

        return redirect()->route('lembur.index')->with('status', 'Pengajuan lembur berhasil diperbarui.');
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

    public function approvalPage()
    {
        $lemburPending = Lembur::with('karyawan')->where('status_lembur', 'Pending')->paginate(10);
        return view('lembur.approval', compact('lemburPending'));
    }

    
    public function approveLembur($id)
{
    $lembur = Lembur::findOrFail($id);
    $lembur->status_lembur = 'Disetujui';
    
    // Hitung bonus lembur otomatis (misalnya gaji sehari dibagi 8 jam dikali jam lembur)
    $gaji_per_jam = $lembur->karyawan->gaji / 8;
    $lembur->bonus_lembur = $gaji_per_jam * $lembur->jam_lembur;

    $lembur->save();

    return redirect()->route('lembur.approvalPage')->with('status', 'Lembur berhasil disetujui!');
}


    public function reject($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->status_lembur = 'Ditolak';
        $lembur->save();

        return redirect()->route('lembur.approvalPage')->with('status', 'Pengajuan lembur ditolak.');
    }
}
