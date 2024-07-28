<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pekerjaan', 'target_harian','harga_per_unit'];

    protected $table = 'pekerjaan';
    protected $primaryKey = 'id_pekerjaan';
}