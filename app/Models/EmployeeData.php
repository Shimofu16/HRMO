<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeData extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = [
        'salary_grade_step_amount'
    ];

    public function getSalaryGradeStepAmount()
    {
        foreach ($this->salaryGrade->steps as $key => $step) {
            if ($step['step'] == $this->salary_grade_step) {
                return number_format($step['amount'], 2);
            }
        };
        return 0;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function salaryGrade()
    {
        return $this->belongsTo(SalaryGrade::class, 'salary_grade_id');
    }
}
