<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto',
        'email',
        'latitude',
        'longitude',
        
    ];

    protected $table = 'absensi';
    protected $primaryKey = 'id';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'email', 'email_karyawan');
    }
    public function hitungBonusAbsensi()
    {
        $statusKaryawan = $this->karyawan->status_karyawan;
        $bonus = 0;
        
        switch ($statusKaryawan) {
            case 'borongan':
                $bonus = 20000;
                break;
            case 'harian':
                $bonus = 25000;
                break;
            case 'tetap':
                $bonus = 30000;
                break;
        }

        return $bonus;
}
}