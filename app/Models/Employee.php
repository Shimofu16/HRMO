<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = ['full_name'];

    /**
     * The attributes the full name of employee.
     *
     * @var array
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    /**
     * Get the category associated with the employee.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    /**
     * Get the category associated with the employee.
     */
    public function allowances()
    {
        return $this->hasMany(EmployeeAllowance::class, 'employee_id');
    }

    /**
     * Get the category associated with the employee.
     */
    public function deductions()
    {
        return $this->hasMany(EmployeeDeduction::class, 'employee_id');
    }

    /**
     * Get the seminar attendances request associated with the employee.
     */
    public function seminarAttendances()
    {
        return $this->hasMany(SeminarAttendance::class, 'employee_id');
    }


    /**
     * Get the sick leave request associated with the employee.
     */
    public function sickLeaveRequests()
    {
        return $this->hasMany(SickLeaveRequest::class);
    }

    /**
     *  Get the loans associated with the employee.
     *
     */
    public function loans()
    {
        return $this->hasMany(EmployeeLoan::class, 'employee_id');
    }
    /**
     *  Get the loans associated with the employee.
     *
     */
    public function data()
    {
        return $this->hasOne(EmployeeData::class, 'employee_id');
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
            $amount = $deduction->deduction->deduction_amount;
            if ($deduction->deduction->deduction_amount_type == 'percentage') {
                // convert fixed amount to percentage
                // example: the value of amount is 10 so convert it to .10
                $amount = $amount / 100;
                if ($deduction->deduction->deduction_name == 'Phil Health') {
                    $amount = ($this->data->salary_grade_step_amount / 2) * .02;
                }
            }
            $totalDeduction += $amount;
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

    public function getDeductionsBy($type)
    {
        return $this->deductions()
            ->whereHas('deduction', function ($query) use ($type) {
                $query->where('deduction_type', $type);
            })
            ->get();
    }
}
