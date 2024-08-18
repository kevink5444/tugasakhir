<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiHarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_karyawan',
        'tanggal_awal', 
        'tanggal_akhir', 
        'id_pekerjaan',
        'jumlah_pekerjaan',
        'target_harian',
        'capaian_harian',
        'gaji_harian',
        'bonus_harian',
        'denda_harian',
        'status_pengambilan',
        'total_gaji'
    ];
    protected $dates = ['tanggal']; 
    protected $table = 'gaji_harian';
    protected $primaryKey = 'id_gaji_harian';

    public function karyawan()
{
    return $this->belongsTo(Karyawan::class, 'id_karyawan');
}

public function pekerjaan()
{
    return $this->belongsTo(Pekerjaan::class, 'id_pekerjaan');
}
public function getTotalGajiSemingguAttribute()
{
    return $this->gaji_harian * 6;
}
}
