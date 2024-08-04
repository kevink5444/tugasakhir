<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    use HasFactory;

    protected $table = 'slip_gaji';

    protected $fillable = [
        'id_karyawan',
        'periode',
        'tanggal_slip',
        'total_gaji',
        'bonus',
        'denda',
        'total_pekerjaan',
        'total_lembur',
        'bonus_lembur',
        'uang_transport',
        'uang_makan',
        'thr',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
