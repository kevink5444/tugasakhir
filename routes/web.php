<?php
use App\Http\Controllers\GajiBoronganController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CapaianController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PengaturanTargetController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\GajiBulananController;
use App\Http\Controllers\GajiHarianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Rute yang bisa diakses oleh semua role
Route::get('/', function () {
    return view('welcome');
});



Route::get('pekerjaan', [PekerjaanController::class, 'index'])->name('pekerjaan.index');
Route::get('pekerjaan/create', [PekerjaanController::class, 'create'])->name('pekerjaan.create');
Route::post('pekerjaan', [PekerjaanController::class, 'store'])->name('pekerjaan.store');
Route::get('pekerjaan/{id_pekerjaan}/edit', [PekerjaanController::class, 'edit'])->name('pekerjaan.edit');
Route::put('pekerjaan/{id_pekerjaan}', [PekerjaanController::class, 'update'])->name('pekerjaan.update');
Route::delete('pekerjaan/{id_pekerjaan}', [PekerjaanController::class, 'destroy'])->name('pekerjaan.destroy');

Route::get('pengaturan_target', [PengaturanTargetController::class, 'index'])->name('pengaturan_target.index');
Route::get('pengaturan_target/create', [PengaturanTargetController::class, 'create'])->name('pengaturan_target.create');
Route::post('pengaturan_target', [PengaturanTargetController::class, 'store'])->name('pengaturan_target.store');
Route::get('pengaturan_target/{id}/edit', [PengaturanTargetController::class, 'edit'])->name('pengaturan_target.edit');
Route::put('pengaturan_target/{id}', [PengaturanTargetController::class, 'update'])->name('pengaturan_target.update');
Route::delete('pengaturan_target/{id}', [PengaturanTargetController::class, 'destroy'])->name('pengaturan_target.destroy');

Route::get('laporan/absensi', [LaporanController::class, 'laporanAbsensi'])->name('laporan.absensi');
Route::get('laporan/penggajian', [LaporanController::class, 'laporanPenggajian'])->name('laporan.penggajian');
Route::get('laporan/karyawan', [LaporanController::class, 'laporanKaryawan'])->name('laporan.karyawan');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rute untuk absensi
Route::prefix('absensi')->group(function () {
    Route::get('/', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/check-in', [AbsensiController::class, 'checkIn'])->name('absen-masuk');
    Route::post('/check-out', [AbsensiController::class, 'checkOut'])->name('absen-keluar');
    Route::get('/qr/{id_karyawan}', function ($id_karyawan) {
        return QrCode::size(300)->generate(route('absen-masuk', ['id_karyawan' => $id_karyawan]));
    })->name('absensi.qr');
    Route::get('/form', [AbsensiController::class, 'buat'])->name('absensi.form');
    Route::post('/simpan', [AbsensiController::class, 'simpan'])->name('absensi.simpan');
});
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');

// Route untuk menampilkan form input absensi
Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');

// Route untuk menyimpan data absensi
Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

// Route untuk menampilkan detail absensi (tambahkan route ini jika Anda ingin detail)
Route::get('/absensi/{id}', [AbsensiController::class, 'show'])->name('absensi.show');
Route::get('/karyawan', [\App\Http\Controllers\KaryawanController::class, 'index'])->name('karyawan.index');
Route::get('/karyawan/create', [\App\Http\Controllers\KaryawanController::class, 'create'])->name('karyawan.create');
Route::post('/karyawan', [\App\Http\Controllers\KaryawanController::class, 'store'])->name('karyawan.store');
Route::get('/karyawan/{id}/edit', [\App\Http\Controllers\KaryawanController::class, 'edit'])->name('karyawan.edit');
Route::put('/karyawan/{id}', [\App\Http\Controllers\KaryawanController::class, 'update'])->name('karyawan.update');
Route::delete('/karyawan/{id}', [\App\Http\Controllers\KaryawanController::class, 'destroy'])->name('karyawan.destroy');
// Rute untuk penggajian



Route::post('/lembur/ajukan', [LemburController::class, 'ajukanLembur'])->name('lembur.ajukan');
Route::post('/lembur/setujui/{id}', [LemburController::class, 'setujuiLembur'])->name('lembur.setujui');


    Route::prefix('penggajian')->group(function () {
        Route::get('/penggajian/gaji_borongan/{id_gaji_borongan}/cetak_pdf', [PenggajianController::class, 'cetakSlipGajiPdf'])->name('gaji_borongan.cetak_pdf');
        Route::get('/gaji-borongan/{id}/download-pdf', [GajiBoronganController::class, 'downloadPdf'])->name('gaji-borongan.downloadPdf');

        Route::get('/', [PenggajianController::class, 'index'])->name('penggajian.index');
        Route::get('gaji-bulanan', [PenggajianController::class, 'showGajiBulanan'])->name('penggajian.gaji_bulanan');
        Route::get('gaji-mingguan', [PenggajianController::class, 'showGajiMingguan'])->name('penggajian.gaji_mingguan');
        Route::get('slip-gaji/{id_karyawan}', [PenggajianController::class, 'showSlipGaji'])->name('penggajian.slip_gaji');
        Route::post('generate-gaji-bulanan', [PenggajianController::class, 'generateGajiBulanan'])->name('penggajian.generate_gaji_bulanan');
        Route::post('generate-gaji-mingguan', [PenggajianController::class, 'generateGajiMingguan'])->name('penggajian.generate_gaji_mingguan');
        Route::resource('gaji_borongan', GajiBoronganController::class);

        Route::resource('gaji_bulanan', GajiBulananController::class);
        Route::get('gaji_borongan/{id}/cetak_slip', [GajiBoronganController::class, 'cetakSlipGaji'])->name('gaji_borongan.cetak_slip');
Route::put('gaji_borongan/{id}/ambil_gaji', [GajiBoronganController::class, 'ambilGaji'])->name('gaji_borongan.ambil_gaji');
Route::resource('gaji_harian', GajiHarianController::class);
Route::get('gaji_harian/ambil_gaji/{id}', [GajiHarianController::class, 'ambilGaji'])->name('gaji_harian.ambil_gaji');
Route::get('gaji_harian/cetak_slip/{id}', [GajiHarianController::class, 'cetakSlipGaji'])->name('gaji_harian.cetak_slip');
Route::resource('gaji_borongan', GajiBoronganController::class);
Route::put('gaji_borongan/{id}', [GajiBoronganController::class, 'update'])->name('gaji_borongan.update');

Route::resource('gaji_bulanan', GajiBulananController::class);
Route::get('gaji_bulanan/{gaji_bulanan}/takeSalary', [GajiBulananController::class, 'takeSalary'])->name('gaji_bulanan.takeSalary');
Route::get('gaji_bulanan/{gaji_bulanan}/generatePayslip', [GajiBulananController::class, 'generatePayslip'])->name('gaji_bulanan.generatePayslip');
    
});
    
// Rute untuk lembur
Route::get('/lembur/{id}/approve', [LemburController::class, 'approveLembur'])->name('lembur.approve');
Route::get('/lembur/{id}/reject', [LemburController::class, 'rejectLembur'])->name('lembur.reject');

// Rute untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rute untuk halaman welcome
Route::view('/welcome', 'welcome');

// Include routes for authentication
require __DIR__.'/auth.php';
