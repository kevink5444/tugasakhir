<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    protected $table = 'lembur';
    protected $fillable = ['id_karyawan', 'jam_lembur', 'tanggal', 'status_lembur', 'bonus_lembur'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}