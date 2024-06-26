<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'email_karyawan',
        'alamat_karyawan',
        'created_at',
        'updated_at',
        'status_karyawan'
    ];
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
    public function penggajian()
    {
        return $this->hasMany(Penggajian::class, 'id_karyawan');
    }
}
