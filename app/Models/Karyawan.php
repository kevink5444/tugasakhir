<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_karyawan',
        'alamat_karyawan',
        'email_karyawan',
        'jenis_karyawan',
        'posisi',
        'tanggal_masuk',
        'status'
    ];

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function penggajian()
    {
        return $this->hasMany(Penggajian::class, 'id_karyawan', 'id_karyawan');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'email', 'email_karyawan');
    }
    public function gajiHarian()
    {
        return $this->hasMany(GajiHarian::class, 'id_karyawan');
    }
}