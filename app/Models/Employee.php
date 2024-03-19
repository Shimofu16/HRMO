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
        return $this->deductions()->whereHas('deduction', function ($query) use ($type) {
            $query->where('deduction_type', $type);
        })->get();
    }

    public function countAttendance($type, $month, $year, $from, $to)
    {
        // Parse month and year
        $month = Carbon::parse($month)->format('m');
        $year = Carbon::parse($year)->format('Y');

        // Define date range
        $fromDate = Carbon::create($year, $month, $from)->subDay();
        $toDate = Carbon::create($year, $month, $to)->addDay();

        // Initialize count variable
        $count = 0;
        $days = [];
        for ($i = $to; $i <= $from; $i++) {
            $days[] = $i;
        }
        $query = $this->attendances()
            ->query()
            ->whereBetween('created_at', [$from, $to]);
        // Query attendances based on the type
        switch ($type) {
            case 'present':
                return $query
                    ->where('isPresent', 1)
                    ->count();
            case 'absent':
                // Generate series of dates within the specified range
                $dateSeries = DB::table('attendances')
                    ->selectRaw("DATE_ADD('{$fromDate}', INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY) AS date")
                    ->from(
                        DB::raw('(SELECT 0 AS a UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) AS a'),
                        DB::raw('(SELECT 0 AS a UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) AS b'),
                        DB::raw('(SELECT 0 AS a UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) AS c')
                    )
                    ->whereRaw("DATE_ADD('{$fromDate}', INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY) BETWEEN '{$fromDate}' AND '{$toDate}'");

                // Left join with attendances table and count the null records (absent events)
                return $this->attendances()
                    ->leftJoinSub($dateSeries, 'date_series', function ($join) {
                        $join->onDate('attendances.created_at', '=', 'date_series.date');
                    })
                    ->whereNull('date_series.date')
                    ->orWhere('isPresent', 0)
                    ->count();
                break;
            case 'late':
                // Your existing late counting logic here
                break;
            case 'undertime':
                // Your existing undertime counting logic here
                break;
            case 'manhours':
                // Your existing manhours counting logic here
                break;
        }

        // if ($type === "present") {
        //     $count = $query
        //         ->where('isPresent', 1)
        //         ->count();
        // }
        // if ($type === "absent") {
        //     $presents = $this->attendances()
        //         ->whereBetween('created_at', [$from, $to])
        //         ->where('isPresent', 1)
        //         ->get();
        //     foreach ($days as $key => $day) {
        //     }
        // }

        // if ($type === "undertime") {
        //     $count = $this->attendances()
        //         ->whereBetween('created_at', [$from, $to])
        //         ->where(function ($query) {
        //             $query->where('time_out_status', 'LIKE', '%undertime%');
        //         })
        //         ->where('isPresent', 1)
        //         ->count();
        // }
        // if ($type == "manhours") {
        //     $count = $this->attendances()
        //         ->whereBetween('created_at', [$from, $to])
        //         ->where('isPresent', 1)
        //         ->sum('hours');
        // }


    }
}
