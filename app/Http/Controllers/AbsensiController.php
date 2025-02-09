<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\GajiBulanan;
use App\Models\GajiHarian;
use App\Models\GajiBorongan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dan tahun saat ini jika tidak ada filter
        $bulanTahun = $request->query('bulan_tahun', Carbon::now()->format('m/Y'));
        list($bulan, $tahun) = explode('/', $bulanTahun);

        // Query absensi berdasarkan bulan dan tahun yang dipilih
        $absensi = Absensi::with('karyawan')
            ->whereMonth('waktu_masuk', $bulan)
            ->whereYear('waktu_masuk', $tahun)
            ->get();

        return view('absensi.index', compact('absensi', 'bulanTahun'));
    }

    public function create()
    {
        $karyawan = Karyawan::all(); // Ambil semua karyawan untuk form input
        return view('absensi.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'status' => 'required|in:masuk,izin,sakit,alpha',
            'waktu_masuk' => 'nullable|date_format:Y-m-d\TH:i',
            'waktu_pulang' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:waktu_masuk',
        ]);

        $absensi = new Absensi();
        $absensi->id_karyawan = $request->id_karyawan;
        $absensi->status = $request->status;

        $timezone = config('app.timezone');

        $absensi->waktu_masuk = $request->waktu_masuk 
            ? Carbon::parse($request->waktu_masuk)->setTimezone($timezone)
            : Carbon::now($timezone);

        $absensi->waktu_pulang = $request->waktu_pulang 
            ? Carbon::parse($request->waktu_pulang)->setTimezone($timezone)
            : Carbon::now($timezone);

        $bonus = 0;
        $denda = 0;

        if ($absensi->waktu_masuk) {
            $jamMasuk = Carbon::parse($absensi->waktu_masuk);
            $jamBatas = Carbon::today($timezone)->setTime(8, 0, 0);
            $jamBatasTerlambat = $jamBatas->copy()->addMinutes(5);
            $jamBatasMaksDenda = $jamBatas->copy()->addHours(1);

            if ($jamMasuk->lt($jamBatas)) {
                $bonus = 25000;
            }

            if ($jamMasuk->gt($jamBatasTerlambat) && $jamMasuk->lte($jamBatasMaksDenda)) {
                $denda = 10000;
            }
        }

        $absensi->bonus = $bonus;
        $absensi->denda = $denda;
        $absensi->save();

        // Integrasi bonus dan denda ke dalam gaji
        $this->updateGaji($absensi);

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dicatat.');
    }
    
    public function filter(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

    // Validasi input bulan dan tahun
    $request->validate([
        'bulan' => 'nullable|integer|between:1,12',
        'tahun' => 'nullable|integer|min:2000|max:' . date('Y'),
    ]);

    // Query data gaji harian dengan filter bulan dan tahun
    $absensi = Absensi::with('karyawan')
        ->when($bulan, function ($query, $bulan) {
            return $query->whereMonth('waktu_masuk', $bulan);
        })
        ->when($tahun, function ($query, $tahun) {
            return $query->whereYear('waktu_masuk', $tahun);
        })
        ->get();

        // Passing data filter ke view
        return view('absensi.index', compact('absensi', 'bulan', 'tahun'));
    }
    private function updateGaji(Absensi $absensi)
    {
        $karyawan = $absensi->karyawan;
        $bulan = Carbon::now()->format('Y-m'); // Format bulan untuk memfilter data gaji

        // Menggunakan jenis_karyawan untuk memutuskan tipe gaji yang akan diperbarui
        switch ($karyawan->jenis_karyawan) {
            case 'bulanan':
                $gaji = GajiBulanan::firstOrCreate(
                    ['id_karyawan' => $karyawan->id_karyawan, 'bulan' => $bulan],
                    ['total_gaji' => 0, 'bonus' => 0, 'denda' => 0]
                );
                break;

            case 'harian':
                $tanggal = Carbon::now()->format('Y-m-d'); // Format tanggal untuk gaji harian
                $gaji = GajiHarian::firstOrCreate(
                    ['id_karyawan' => $karyawan->id_karyawan, 'tanggal' => $tanggal],
                    ['total_gaji' => 0, 'bonus' => 0, 'denda' => 0]
                );
                break;

            case 'borongan':
                $gaji = GajiBorongan::firstOrCreate(
                    ['id_karyawan' => $karyawan->id_karyawan, 'bulan' => $bulan],
                    ['total_gaji' => 0, 'bonus' => 0, 'denda' => 0]
                );
                break;

            default:
                Log::error('Tipe gaji karyawan tidak valid untuk karyawan: ' . $karyawan->id_karyawan);
                return;
        }

        if (isset($gaji)) {
            // Update bonus dan denda untuk absensi karyawan
            $gaji->bonus += $absensi->bonus;
            $gaji->denda += $absensi->denda;
            $gaji->save();
        } else {
            Log::error('Gagal memperbarui gaji: Objek gaji tidak ditemukan atau tidak bisa dibuat.');
        }
    }
}