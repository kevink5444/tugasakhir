<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiBorongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_karyawan',
        'minggu_mulai',
        'minggu_selesai',
        'total_gaji_borongan',
        'total_bonus',
        'total_denda',
        'total_pekerjaan',
        'total_lembur',
        'bonus_lembur',
        'status_pengambilan',
    ];

    protected $table = 'gaji_borongan';
    protected $primaryKey = 'id_gaji_borongan';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
