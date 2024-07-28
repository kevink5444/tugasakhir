<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capaian extends Model
{
    use HasFactory;

    protected $fillable = ['id_capaian','id_karyawan', 'id_pekerjaan', 'jumlah_capaian','created_at','updated_at'];

    protected $table = 'capaian';
    protected $primaryKey = 'id_capaian';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'id_pekerjaan');
    }
}