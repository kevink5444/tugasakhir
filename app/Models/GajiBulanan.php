<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiBulanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulan',
        'gaji_pokok',
        'uang_transport',
        'uang_makan',
        'bonus',
        'thr',
        'total_gaji',
        'total_lembur',
        'bonus_lembur',
        'denda'
        
    ];

    protected $table = 'gaji_bulanan';
    protected $primaryKey = 'id_gaji__bulanan';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
    
}