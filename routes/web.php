<?php

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rute yang bisa diakses oleh admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/karyawan', [\App\Http\Controllers\KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/create', [\App\Http\Controllers\KaryawanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan', [\App\Http\Controllers\KaryawanController::class, 'store'])->name('karyawan.store');
    Route::get('/karyawan/{id}/edit', [\App\Http\Controllers\KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/{id}', [\App\Http\Controllers\KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/{id}', [\App\Http\Controllers\KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    Route::get('/penggajian', [\App\Http\Controllers\PenggajianController::class, 'index'])->name('penggajian');
    Route::get('penggajian/create', [\App\Http\Controllers\PenggajianController::class, 'create'])->name('penggajian.create');
    Route::get('penggajian/{id_penggajian}/edit', [\App\Http\Controllers\PenggajianController::class, 'edit'])->name('penggajian.edit');
    Route::put('penggajian/{id_penggajian}', [\App\Http\Controllers\PenggajianController::class, 'update'])->name('penggajian.update');
    Route::delete('penggajian/{id_penggajian}', [\App\Http\Controllers\PenggajianController::class, 'delete'])->name('penggajian.delete');
    Route::post('/penggajian', [\App\Http\Controllers\PenggajianController::class, 'store'])->name('penggajian.store');
});

// Rute yang bisa diakses oleh karyawan
Route::middleware(['auth'])->group(function () {
    Route::get('/absensi/form-absen', [\App\Http\Controllers\AbsensiController::class, 'formAbsen'])->name('absensi.form-absen');
});

// Rute untuk QR Code
Route::get('/absensi/qr/{id_karyawan}', function ($id_karyawan) {
    return QrCode::size(300)->generate(route('absen-masuk', ['id_karyawan' => $id_karyawan]));
})->name('absensi.qr');

// Rute untuk absensi
Route::prefix('absensi')->group(function () {
    Route::get('/form', [\App\Http\Controllers\AbsensiController::class, 'showForm'])->name('absensi.form');
    Route::get('/', [\App\Http\Controllers\AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/check-in', [\App\Http\Controllers\AbsensiController::class, 'checkIn'])->name('absen-masuk');
    Route::post('/check-out', [\App\Http\Controllers\AbsensiController::class, 'checkOut'])->name('absen-keluar');
});

// Rute untuk halaman welcome
Route::view('/welcome', 'welcome');

// Include routes for authentication
require __DIR__.'/auth.php';
