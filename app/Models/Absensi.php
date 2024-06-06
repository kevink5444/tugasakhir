<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{   
    use HasFactory;
    protected $table = 'absensi';
    protected $fillable = [
        'user_id',
        'clock_in',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
