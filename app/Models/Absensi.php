<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_karyawan',
        'waktu_masuk',
        'waktu_keluar',
        'status',
        'jumlah'
    ];
}
