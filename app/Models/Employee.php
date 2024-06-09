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
    public function promotions()
    {
        return $this->hasMany(EmployeePromotion::class, 'employee_id');
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
                    if ($range == $allowance_range) {
                        if ($allowance->allowance->allowance_code == 'Hazard' || $allowance->allowance->allowance_code == 'Representation' || $allowance->allowance->allowance_code == 'Transportation') {
                            if ($allowance->allowance->allowance_code == 'Hazard') {
                                $totalAllowance = $totalAllowance + getHazard($this->data->salary_grade_id, $this->data->monthly_salary);
                            } else {
                                // dd(getHazard($this->data->salary_grade_id, $this->data->monthly_salary));
                                $totalAllowance = $totalAllowance + $allowance->amount;
                            }
                        } else {
                            $totalAllowance = $totalAllowance + $allowance->allowance->allowance_amount;
                        }
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
                    $percentage = $amount / 100;
                    $amount = $this->data->monthly_salary * $percentage;
                }
                $totalDeduction += $amount;
            }
        } else {
            // Compute deduction for specific range
            foreach ($this->deductions as $deduction) {
                if ($range == $deduction->deduction->deduction_range) {
                    $amount = $deduction->deduction->deduction_amount;
                    if ($deduction->deduction->deduction_amount_type == 'percentage') {
                        $percentage = $amount / 100;
                        $amount = $this->data->monthly_salary * $percentage;
                    }
                    $totalDeduction += $amount;
                }
            }
        }

        if ($this->data->holding_tax) {
            $totalDeduction += $this->data->holding_tax;
        }
        if ($this->loans) {
            foreach ($this->loans as $key => $loan) {
                foreach ($loan->ranges as $key => $loan_range) {
                    if ($range == $loan_range) {
                        $totalDeduction += $loan->amount;
                    }
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
    public function getAllowance($allowance_id, $range  = null)
    {
        if ($range) {
            $allowance = $this->allowances()->where('allowance_id', $allowance_id)->first();
            if ($allowance) {
                foreach ($allowance->allowance->allowance_ranges as $key => $allowance_range) {
                    if ($range == $allowance_range) {
                        if ($allowance->allowance->allowance_code == 'Hazard' || $allowance->allowance->allowance_code == 'Representation' || $allowance->allowance->allowance_code == 'Transportation') {
                            if ($allowance->allowance->allowance_code == 'Hazard') {
                                return getHazard($this->data->salary_grade_id, $this->data->monthly_salary);
                            } else {
                                // dd(getHazard($this->data->salary_grade_id, $this->data->monthly_salary));
                                return $allowance->amount;
                            }
                        } else {
                            return $allowance->allowance->allowance_amount;
                        }
                    }
                }
            }
            return 0;
        } else {
            $allowance = $this->allowances()->where('allowance_id', $allowance_id)->first();
            if ($allowance) {
                if ($allowance->allowance->allowance_code == 'Hazard' || $allowance->allowance->allowance_code == 'Representation' || $allowance->allowance->allowance_code == 'Transportation') {
                    if ($allowance->allowance->allowance_code == 'Hazard') {
                        return getHazard($this->data->salary_grade_id, $this->data->monthly_salary);
                    } else {
                        // dd(getHazard($this->data->salary_grade_id, $this->data->monthly_salary));
                        return $allowance->amount;
                    }
                } else {
                    return $allowance->allowance->allowance_amount;
                }
            }
            return 0;
        }
    }
    public function getDeduction($deduction_id, $range)
    {
        $deduction = $this->deductions()->where('deduction_id', $deduction_id)->first();
        if ($deduction) {
            if ($range) {
                if ($range == $deduction->deduction->deduction_range) {
                    $amount = $deduction->deduction->deduction_amount;
                    if ($deduction->deduction->deduction_amount_type == 'percentage') {
                        $percentage = $amount / 100;
                        $amount = $this->data->monthly_salary * $percentage;
                    }
                    return $amount;
                }
            } else {
                $amount = $deduction->deduction->deduction_amount;
                if ($deduction->deduction->deduction_amount_type == 'percentage') {
                    $percentage = $amount / 100;
                    $amount = $this->data->monthly_salary * $percentage;
                }
                return $amount;
            }
        }
        return 0;
    }
    public function getLoan($loan_id, $range, $date)
    {
        $loan = $this->loans()->where('loan_id', $loan_id)->first();

        if ($loan) {
            $current_date = Carbon::parse($date);
            $start_date = Carbon::parse($loan->start_date);
            $end_date = Carbon::parse($loan->end_date);
            foreach ($loan->ranges as $key => $ranges) {
                if ($ranges == $range && $current_date->between($start_date, $end_date)) {
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
    private function getHazard($salary_grade_id, $salary_grade)
    {
        switch ($salary_grade_id) {
            case 19:
                return $salary_grade * 0.25;
            case 20:
                return $salary_grade * 0.15;
            case 21:
                return $salary_grade * 0.13;
            case 22:
                return $salary_grade * 0.12;
            case 23:
                return $salary_grade * 0.11;
            case 24:
                return $salary_grade * 0.10;
            case 25:
                return $salary_grade * 0.10;
            case 26:
                return $salary_grade * 0.09;
            case 27:
                return $salary_grade * 0.08;
            case 28:
                return $salary_grade * 0.087;
            case 29:
                return $salary_grade * 0.06;
            case 30:
                return $salary_grade * 0.05;
        }
    }
}
