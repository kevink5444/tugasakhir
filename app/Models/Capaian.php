<?php

// app/Models/Capaian.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capaian extends Model
{
    use HasFactory;

    protected $table = 'capaian'; // Nama tabel dalam database

    protected $primaryKey = 'id_capaian'; // Jika primary key bukan 'id', sesuaikan dengan primary key tabel Anda

    public $timestamps = true; // Aktifkan jika tabel memiliki kolom 'created_at' dan 'updated_at'

    protected $fillable = [
        'id_karyawan',
        'id_pekerjaan',
        'jumlah_capaian',
        'tanggal',
    ];

    // Relasi dengan model Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    // Relasi dengan model Pekerjaan
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'id_pekerjaan');
    }
}
