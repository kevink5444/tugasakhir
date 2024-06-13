<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');

});

use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

use App\Http\Controllers\AbsensiController;


Route::middleware(['auth'])->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absen-masuk/{id_karyawan}', [AbsensiController::class, 'absenMasuk'])->name('absen-masuk');
    Route::post('/absen-keluar/{id_karyawan}', [AbsensiController::class, 'absenKeluar'])->name('absen-keluar');
});


use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');


use App\Http\Controllers\PenggajianController;
Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian');
Route::get('penggajian/create', [PenggajianController::class, 'create'])->name('penggajian.create');

// Route untuk menampilkan form edit
Route::get('penggajian/{penggajian}/edit', [PenggajianController::class, 'edit'])->name('penggajian.edit');



// Route untuk menyimpan perubahan
Route::put('penggajian/{penggajian}', [PenggajianController::class, 'update'])->name('penggajian.update');

// Pastikan juga ada route untuk menampilkan index penggajian
Route::delete('penggajian/{penggajian}', [PenggajianController::class, 'destroy'])->name('penggajian.destroy');

Route::get('/laporan', function () {
    return view('laporan');
});

Route::get('/pengaturan', function () {
    return view('pengaturan');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/attendance', function () {
    return view('attendance');
});


require __DIR__.'/auth.php';


