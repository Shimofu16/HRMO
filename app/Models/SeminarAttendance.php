<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarAttendance extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
