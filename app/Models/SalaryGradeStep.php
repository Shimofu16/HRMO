<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryGradeStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_grade_id',
        'step',
        'amount',
    ];
}
