<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    protected $table = 'lembur';
    protected $fillable = [
        'id_karyawan', 'jam_lembur', 'tanggal_lembur', 
        'status_lembur', 'bonus_lembur'
    ];
    protected $primaryKey = 'id_lembur';
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function hitungBonusLembur($jam_lembur, $gaji_per_hari)
    {
        $rate_per_jam = $gaji_per_hari / 8; 
        return $jam_lembur * $rate_per_jam; 
    }
    public function index()
{
    
    $lembur = Lembur::paginate(10); 
    return view('lembur.index', compact('lembur'));
}
}