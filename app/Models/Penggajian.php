<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Penggajian extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_karyawan',
        'gaji_pokok',
        'bonus',
        'denda',
        'total_gaji',
        'created_at',
        'updated_at'
    ];
    protected $table = 'penggajian';
    protected $primaryKey = 'id_penggajian';

    public function karyawan(): BelongsTo
    {
        // return $this->belongsTo(Karyawan::class)->withTrashed();
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan')->withTrashed();
    }
}
