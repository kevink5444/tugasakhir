<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanTarget extends Model
{
    use HasFactory;

    protected $fillable = ['id_pekerjaan', 'target_mingguan'];

    protected $table = 'target';
    protected $primaryKey = 'id_target';

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'id_pekerjaan', 'id_pekerjaan');
    }
}