<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $fillable = [
       'tanggal',
       'terlambat',
       'denda'
        
    ];

    protected $table = 'denda_telat';
    protected $primaryKey = 'id_denda_telat';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id', 'id_karyawan');
    }
}
    