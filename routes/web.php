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
use App\Http\Controllers\AttendanceController;

Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');

Route::get('/', function () {
    return view('welcome');

});

use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

use App\Http\Controllers\AbsensiController;

Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');



use App\Http\Controllers\PenggajianController;

// Route untuk penggajian
Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
Route::get('penggajian/create', [PenggajianController::class, 'create'])->name('penggajian.create');
Route::get('penggajian/{penggajian}/edit', [PenggajianController::class, 'edit'])->name('penggajian.edit');
Route::put('penggajian/{penggajian}', [PenggajianController::class, 'update'])->name('penggajian.update');
Route::delete('penggajian/{penggajian}', [PenggajianController::class, 'destroy'])->name('penggajian.destroy');

Route::get('/laporan', function () {
    return view('laporan');
});

Route::get('/pengaturan', function () {
    return view('pengaturan');
});


Route::get('/attendance', function () {
    return view('attendance');
});


require __DIR__.'/auth.php';


