<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    
    protected $table = 'absensi'; // Nama tabel sesuai dengan yang ada di database
    protected $primaryKey = 'id_absensi'; // Nama primary key dari tabel

    protected $fillable = [
        'id_karyawan',
        'waktu_masuk',
        'waktu_keluar',
        'status'
    ];

    // Pastikan untuk menggunakan timestamps jika ada kolom created_at dan updated_at di tabel
    public $timestamps = true;

    // Tambahkan mutator atau accessor jika diperlukan untuk manipulasi atau pengambilan data
}
