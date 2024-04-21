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

    public function computeAllowance($dates = null)
    {
        $totalAllowance = 0;

        // If no specific dates provided, compute allowance for all dates
        if (!$dates) {
            foreach ($this->allowances as $allowance) {
                $totalAllowance += $allowance->allowance->allowance_amount;
            }
        } else {
            // Compute allowance for specific dates
            foreach ($this->allowances as $allowance) {
                if ($dates == $allowance->allowance_range) {
                    $totalAllowance += $allowance->allowance->allowance_amount;
                }
            }
        }

        return $totalAllowance;
    }

    public function computeDeduction($dates = null)
    {
        $totalDeduction = 0;

        // If no specific dates provided, compute deduction for all dates
        if (!$dates) {
            foreach ($this->deductions as $deduction) {
                $amount = $deduction->deduction->deduction_amount;
                if ($deduction->deduction->deduction_amount_type == 'percentage') {
                    $amount = $amount / 100;
                    if ($deduction->deduction->deduction_name == 'Phil Health') {
                        $amount = ($this->data->salary_grade_step_amount / 2) * .02;
                    }
                }
                $totalDeduction += $amount;
            }
        } else {
            // Compute deduction for specific dates
            foreach ($this->deductions as $deduction) {
                if ($dates == $deduction->deduction_range) {
                    $amount = $deduction->deduction->deduction_amount;
                    if ($deduction->deduction->deduction_amount_type == 'percentage') {
                        $amount = $amount / 100;
                        if ($deduction->deduction->deduction_name == 'Phil Health') {
                            $amount = ($this->data->salary_grade_step_amount / 2) * .02;
                        }
                    }
                    $totalDeduction += $amount;
                }
            }
        }

        return $totalDeduction;
    }

    public function getTotalSalaryBy($month, $year, $from, $to)
    {
        $month = date('m', strtotime($month));
        $year = date('Y', strtotime($year));
        if (!checkdate($month, $to, $year)) {
            $to = date('t', mktime(0, 0, 0, $month, 1, $year)); // get last day of the month
        }
        $totalSalary = 0;

        $from = sprintf('%04d-%02d-%02d', $year, $month, $from);
        $to = sprintf('%04d-%02d-%02d', $year, $month, $to);


        $from = Carbon::parse($from)->format('Y-m-d'); // Assuming 1st day of the month
        $to = Carbon::parse($to)->format('Y-m-d'); // Use $to for the last day


        $attendances = $this->attendances()->whereBetween('created_at', [$from, $to])->get();
        // dd($attendances, $from, $to);
        // Sum up the allowance amounts
        foreach ($attendances as $attendance) {
            $totalSalary += $attendance->salary;
        }

        return $totalSalary;
    }
    public function getAllowance($allowance_id)
    {
        $allowance = $this->allowances()->where('allowance_id', $allowance_id)->first();
        if ($allowance) {
            return $allowance->allowance->allowance_amount;
        }
        return 0;
    }
    public function getDeduction($deduction_id)
    {
        $deduction = $this->deductions()->where('deduction_id', $deduction_id)->first();
        if ($deduction) {
            return $deduction->deduction->deduction_amount;
        }
        return 0;
    }
    public function getLoan($loan_id, $range)
    {
        $loan = $this->loans()->where('loan_id', $loan_id)->first();

        if ($loan) {
            foreach ($loan->ranges as $key => $ranges) {
                if ($ranges == $range) {
                    return $loan->amount;
                }
            }
        }
        return 0;
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
