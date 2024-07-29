<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penggajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_karyawan',
        'jumlah_capaian',
        'target_mingguan',
        'target_harian',
        'bonus',
        'denda',
        'total_gaji',
        'status_karyawan',
        'email_karyawan'
    ];

    protected $table = 'penggajian';
    protected $primaryKey = 'id_penggajian';

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function hitungLembur($id_karyawan)
    {
        $lembur = Lembur::where('id_karyawan', $id_karyawan)->sum('jam_lembur');
        $karyawan = Karyawan::find($id_karyawan);
        $gajiHarian = 0;

        switch ($karyawan->status_karyawan) {
            case 'borongan':
                $gajiHarian = 150000; // gaji harian contoh untuk borongan
                break;
            case 'harian':
                $gajiHarian = 90000; // gaji harian contoh untuk harian
                break;
            case 'tetap':
                $gajiHarian = 3500000 / 30; // gaji harian contoh untuk tetap
                break;
        }

        $gajiPerJam = $gajiHarian / 8; // asumsikan 8 jam kerja per hari
        return $lembur * $gajiPerJam;
    }
}