<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiBorongan extends Model
{
    use HasFactory;

    protected $table = 'gaji_borongan';
    protected $primaryKey = 'id_gaji_borongan';
    protected $fillable = [
        'id_karyawan',
        'minggu_mulai',
        'minggu_selesai',
        'total_gaji_borongan',
        'total_bonus',
        'total_denda',
        'capaian_harian',
        'total_lembur',
        'bonus_lembur',
        'status_pengambilan',
        'bulan',
        'tahun',
        'bonus',
        'denda'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}