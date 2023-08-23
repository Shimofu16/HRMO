<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the department associated with the employee.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the category associated with the employee.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the category associated with the employee.
     */
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    /**
     * Get the category associated with the employee.
     */
    public function sgrade()
    {
        return $this->belongsTo(Sgrade::class);
    }

    /**
     * Get the category associated with the employee.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function allowance()
    {
        return $this->belongsTo(Allowance::class, 'allowance_id');
    }

    /**
     * Get the category associated with the employee.
     */
    public function deduction()
    {
        return $this->belongsTo(Deduction::class, 'deduction_id');
    }

    /**
     * Get the category associated with the employee.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the category associated with the employee.
     */
    public function allowances()
    {
        return $this->hasMany(EmployeeAllowance::class);
    }

    /**
     * Get the category associated with the employee.
     */
    public function deductions()
    {
        return $this->hasMany(EmployeeDeduction::class);
    }

    public function computeAllowance()
    {
        $totalAllowance = 0;


        // Sum up the allowance amounts
        foreach ($this->allowances as $allowance) {
            $totalAllowance += $allowance->allowance->allowance_amount;
        }

        return $totalAllowance;
    }

    public function computeDeduction()
    {
        $totalDeduction = 0;

        // Sum up the allowance amounts
        foreach ($this->deductions as $deduction) {
            $totalDeduction += $deduction->deduction->deduction_amount;
        }

        return $totalDeduction;
    }
    public function getTotalSalaryBy($month, $year, $from, $to)
    {
        $totalSalary = 0;
        $month = date('m', strtotime($month));
        $year = date('Y', strtotime($year));
        $from = sprintf('%04d-%02d-%02d', $year, $month, $from);
        $to = sprintf('%04d-%02d-%02d', $year, $month, $to);


        $attendances = $this->attendances()->whereBetween('created_at', [$from, $to])->get();
        // dd($attendances, $month, $year, $from, $to);
        // Sum up the allowance amounts
        foreach ($attendances as $attendance) {
            $totalSalary += $attendance->salary;
        }

        return $totalSalary;
    }
}
