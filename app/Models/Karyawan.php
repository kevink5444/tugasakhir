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
        'status_karyawan',
        'target_mingguan',
        'target_harian'
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
}