<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'foto',
        'latitude',
        'longitude',
        'email_karyawan',
        'jam_masuk',
        'jam_keluar',
        'tanggal'
    ];
}
