<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    use HasFactory;
    public function gaji()
{
    return $this->hasMany(Penggajian::class);
}

public function Absensi()
{
    return $this->hasMany(Absensi::class);
}

}
