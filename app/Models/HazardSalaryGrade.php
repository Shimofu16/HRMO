<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HazardSalaryGrade extends Model
{
    use HasFactory;
    protected $fillable = [
        'hazard_id',
        'salary_grade_id',
    ];
}
