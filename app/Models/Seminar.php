<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'departments' => Json::class    
    ];

    public function attendances()
    {
        return $this->hasMany(SeminarAttendance::class);
    }
}
