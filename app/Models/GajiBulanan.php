<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiBulanan extends Model
{
    use HasFactory;

    protected $table = 'gaji_bulanan';

    protected $fillable = [
        'id_karyawan',
        'bulan',
        'gaji_pokok',
        'uang_transport',
        'uang_makan',
        'bonus',
        'thr',
        'total_gaji',
        'total_lembur',
        'bonus_lembur',
        'denda',
        'is_salary_taken',
    ];

    protected $casts = [
        'is_salary_taken' => 'boolean',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
