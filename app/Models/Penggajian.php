<?php 
namespace App\Models;

 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Model;
 
 class Penggajian extends Model
 {  
     use HasFactory;
     protected $table = 'penggajian';
     protected $fillable = [
         'id_karyawan', 'gaji_pokok', 'bonus', 'denda', 'total_gaji'
     ];
 
     public function karyawan()
     {
         return $this->belongsTo(Karyawan::class, 'id_karyawan');
     }
 }
 
// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Penggajian extends Model
// {
    // protected $table = 'penggajian';
    // protected $fillable = ['id_karyawan', 'gaji_pokok', 'bonus', 'denda', 'total_gaji'];

    // public function karyawan()
    // {
        // return $this->belongsTo(Karyawan::class, 'id_karyawan');
    // }
// } 
