<?php

namespace App\Models;

use Carbon\Carbon;
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

    /**
     * Get the sick leave associated with the employee.
     */
    public function sickLeave()
    {
        return $this->hasOne(EmployeeSickLeave::class, 'employee_id');
    }

    /**
     * Get the sick leave request associated with the employee.
     */
    public function sickLeaveRequests()
    {
        return $this->hasMany(SickLeaveRequest::class);
    }

    /**
     *  Get the salary grade step associated with the employee.
     *
     */
    public function salaryGradeStep()
    {
        return $this->belongsTo(SalaryGradeStep::class, 'salary_grade_step_id');
    }

    /**
     *  Get the loans associated with the employee.
     *
     */
    public function loans()
    {
        return $this->hasMany(EmployeeLoan::class, 'employee_id');
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

    public function getDeductionsBy($type)
    {
        return $this->deductions()->whereHas('deduction', function ($query) use ($type) {
            $query->where('deduction_type', $type);
        })->get();
    }

    public function countAttendance($type, $month, $year, $from, $to)
    {
        $count = 0;
        $month = Carbon::parse($month)->format('m');
        $year = Carbon::parse($year)->format('Y');
        $from = Carbon::create($year, $month, $from)->subDay();
        $to = Carbon::create($year, $month, $to)->addDay();

        if ($type === "present") {
            $count = $this->attendances()
                ->whereBetween('created_at', [$from, $to])
                ->where('isPresent', 1)
                ->count();
        }
        if ($type === "absent") {
            $count = $this->attendances()
                ->whereBetween('created_at', [$from, $to])
                ->where('isPresent', 0)
                ->count();
        }
        if ($type === "late") {
            $count = $this->attendances()
                ->whereBetween('created_at', [$from, $to])
                ->where(function ($query) {
                    $query->where('time_in_status', 'LIKE', '%late%');
                })
                ->where('isPresent', 1)
                ->count();
        }
        if ($type === "undertime") {
            $count = $this->attendances()
                ->whereBetween('created_at', [$from, $to])
                ->where(function ($query) {
                    $query->where('time_out_status', 'LIKE', '%undertime%');
                })
                ->where('isPresent', 1)
                ->count();
        }
        if ($type == "manhours") {
            $count = $this->attendances()
                ->whereBetween('created_at', [$from, $to])
                ->where('isPresent', 1)
                ->sum('hours');
        }


        return $count;
    }
}
