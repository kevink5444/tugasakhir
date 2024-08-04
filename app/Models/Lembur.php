<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $fillable = [
        'jam_lembur',
        'tanggal',
        'bonus_lembur'
    ];

    protected $table = 'lembur';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}