<?php

namespace App\Http\Controllers;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\GajiBulanan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class GajiBulananController extends Controller
{
    public function index()
    {
        $gajiBulanan = GajiBulanan::with('karyawan')->get();
        return view('gaji_bulanan.index', compact('gajiBulanan'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        return view('gaji_bulanan.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'bulan' => 'required|date_format:Y-m',
        ]);

        $karyawan = Karyawan::find($request->id_karyawan);
        $gajiPokok = ($karyawan->position === 'admin') ? 3000000 : 2500000;

        GajiBulanan::create([
            'id_karyawan' => $request->id_karyawan,
            'bulan' => $request->bulan,
            'gaji_pokok' => $gajiPokok,
            'uang_transport' => 0,
            'uang_makan' => 0,
            'bonus' => 0,
            'thr' => 0,
            'total_gaji' => $gajiPokok,
            'total_lembur' => 0,
            'bonus_lembur' => 0,
            'denda' => 0,
            'is_salary_taken' => false,
        ]);

        return redirect()->route('gaji_bulanan.index');
    }

    public function edit(GajiBulanan $gajiBulanan)
    {
        return view('gaji_bulanan.edit', compact('gajiBulanan'));
    }

    public function update(Request $request, GajiBulanan $gajiBulanan)
    {
        $gajiBulanan->update($request->all());
        return redirect()->route('gaji_bulanan.index');
    }

    public function destroy(GajiBulanan $gajiBulanan)
    {
        $gajiBulanan->delete();
        return redirect()->route('gaji_bulanan.index');
    }

    public function takeSalary(GajiBulanan $gajiBulanan)
    {
        if ($gajiBulanan->is_salary_taken) {
            return redirect()->back()->with('error', 'Gaji sudah diambil bulan ini.');
        }

        $gajiBulanan->update(['is_salary_taken' => true]);
        return redirect()->back()->with('success', 'Gaji berhasil diambil.');
    }

    public function generatePayslip($id)
    {
        $gajiBulanan = GajiBulanan::with('karyawan')->findOrFail($id);

        // Setup Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);

        // Render view into PDF
        $html = view('gaji_bulanan.payslip', compact('gajiBulanan'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Download PDF
        return $dompdf->stream('slip_gaji_' . $gajiBulanan->id . '.pdf');
    }
}
