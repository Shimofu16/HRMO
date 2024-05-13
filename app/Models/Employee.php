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
    public function leaveRequests()
    {
        return $this->hasMany(EmployeeLeaveRequest::class);
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

    public function computeAllowance($range = null)
    {
        $totalAllowance = 0;
        // If no specific range provided, compute allowance for all range
        if (!$range) {
            foreach ($this->allowances as $allowance) {
                $totalAllowance += $allowance->allowance->allowance_amount;
            }
        } else {
            // Compute allowance for specific dates
            foreach ($this->allowances as $allowance) {
                foreach ($allowance->allowance->allowance_ranges as $key => $allowance_range) {
                    
                    if ($range == $allowance_range){
                        $totalAllowance = $totalAllowance + $allowance->allowance->allowance_amount;
                    }
                }
            }
        }

        return $totalAllowance;
    }

    public function computeDeduction($range = null)
    {
        $totalDeduction = 0;

        // If no specific range provided, compute deduction for all range
        if (!$range) {
            foreach ($this->deductions as $deduction) {
                $amount = $deduction->deduction->deduction_amount;
                if ($deduction->deduction->deduction_amount_type == 'percentage') {
                    $amount = $amount / 100;
                    if ($deduction->deduction->deduction_name == 'Phil Health') {
                        $amount = ($this->data->monthly_salary / 2) * .02;
                    }
                }
                $totalDeduction += $amount;
            }
        } else {
            // Compute deduction for specific range
            foreach ($this->deductions as $deduction) {
                if ($range == $deduction->deduction->deduction_range) {
                    $amount = $deduction->deduction->deduction_amount;
                    if ($deduction->deduction->deduction_amount_type == 'percentage') {
                        $amount = $amount / 100;
                        if ($deduction->deduction->deduction_name == 'Phil Health') {
                            $amount = ($this->data->monthly_salary / 2) * .02;
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
        $totalSalary = 0;
        $month = date('m', strtotime($month));
        $year = date('Y', strtotime($year));
        if (!checkdate($month, $to, $year)) {
            $to = date('t', mktime(0, 0, 0, $month, 1, $year)); // get last day of the month
        }

        $from = sprintf('%04d-%02d-%02d', $year, $month, $from);
        $to = sprintf('%04d-%02d-%02d', $year, $month, $to);


        $from = Carbon::parse($from)->format('Y-m-d'); // Assuming 1st day of the month
        $to = Carbon::parse($to)->format('Y-m-d'); // Use $to for the last day


        $attendances = $this->attendances()->whereBetween('time_in', [$from, $to])->get();
        // dd($attendances, $from, $to, $year);
        // Sum up the allowance amounts
        foreach ($attendances as $attendance) {
            $totalSalary += $attendance->salary;
        }

        return $totalSalary;
    }
    public function getAllowance($allowance_id, $range)
    {
        $allowance = $this->allowances()->where('allowance_id', $allowance_id)->first();
        if ($allowance) {
            foreach ($allowance->allowance->allowance_ranges as $key => $allowance_range) {
                if ($range == $allowance_range){
                    return $allowance->allowance->allowance_amount;
                }
            }
        }
        return 0;
    }
    public function getDeduction($deduction_id, $range)
    {
        $deduction = $this->deductions()->where('deduction_id', $deduction_id)->first();
        if ($deduction) {
            if ($range == $deduction->deduction->deduction_range) {
                $amount = $deduction->deduction->deduction_amount;
                if ($deduction->deduction->deduction_amount_type == 'percentage') {
                    $amount = $amount / 100;
                    if ($deduction->deduction->deduction_name == 'Phil Health') {
                        $amount = ($this->data->monthly_salary / 2) * .02;
                    }
                }
                return $amount;
            }
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
