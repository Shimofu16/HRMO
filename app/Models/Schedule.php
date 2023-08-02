<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'sched_name',
        'start_time',
        'end_time',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'schedule_id');
    }
}
