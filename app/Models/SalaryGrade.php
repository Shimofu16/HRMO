<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'steps',
        // Other fillable attributes
    ];
    protected $casts = [
        'steps' => Json::class
      ];

    public function employees()
    {
        return $this->hasMany(EmployeeData::class, 'salary_grade_id');
    }

    public function payroll()
    {
        return $this->hasMany(Payroll::class, 'salary_grade_id');
    }
}
