<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_karyawan',
        'status',
        'waktu_masuk',
        'waktu_pulang',
        'bonus',
        'denda',
    ];
    protected $casts = [
        'bonus' => 'integer',
        'denda' => 'integer',
        'waktu_masuk' => 'datetime',
        'waktu_pulang' => 'datetime',
    ];


    protected $dates = ['waktu_masuk', 'waktu_pulang'];

    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}