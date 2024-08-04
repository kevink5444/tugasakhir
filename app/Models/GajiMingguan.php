<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiMingguan extends Model
{
    use HasFactory;

    protected $fillable = [
        'minggu_mulai',
        'minggu_selesai',
        'total_gaji_mingguan',
        'total_bonus',
        'total_denda',
        'total_pekerjaan',
        'total_lembur',
        'bonus_lembur',
        
    ];

    protected $table = 'gaji_mingguan';
    protected $primaryKey = 'id_gaji__mingguan';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id', 'id_karyawan');
    }
    
}