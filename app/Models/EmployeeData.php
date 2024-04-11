<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class EmployeeData extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected $appends = ['salary_grade_step_amount'];

    public function getSalaryGradeStepAmountAttribute()
    {
        if ($this->salary_grade_id) {
            foreach ($this->salaryGrade->steps as $key => $step) {
                if (Str::lower($step['step']) == Str::lower($this->salary_grade_step)) {
                    return $step['amount'];
                }
            };
        }
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
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
}
