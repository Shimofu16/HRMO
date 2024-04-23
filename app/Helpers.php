<?php

use App\Models\Attendance;
use App\Models\SalaryGrade;
use App\Models\Seminar;
use Carbon\Carbon;
use Illuminate\Support\Str;



if (!function_exists('createActivity')) {
    function createActivity($type, $message, $ip_address = null, $model = null, $request = null)
    {
        try {
            $updated_from = null;
            $updated_to = null;

            if ($model) {
                // get the only updated fields
                $updated_from = $model->getOriginal();
                $updated_to = $request->all();
                // to json
                $updated_from = json_encode($updated_from);
                $updated_to = json_encode($updated_to);
            }

            auth()->user()->activities()->create([
                'type' => $type,
                'message' => $message,
                'ip_address' => $ip_address,
                'updated_from' => $updated_from,
                'updated_to' => $updated_to,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

if (!function_exists('toCode')) {
    function toCode($text)
    {
        $words = preg_split("/[\s,]+/", $text);
        $code = "";
        $excludedWords = ["of", "the", "is", "it", "and"]; // Add any words you want to exclude here

        foreach ($words as $w) {
            if (!in_array(strtolower($w), $excludedWords)) {
                $code .= Str::upper($w[0]);
            }
        }

        return $code;
    }
}
if (!function_exists('percentage')) {
    function percentage($number)
    {
        return $number . '%';
    }
}
if (!function_exists('money')) {
    function money($number, $currency = 'PHP')
    {
        $currency = Str::upper($currency);
        return $currency . ' ' . $number;
    }
}
if (!function_exists('computePercentage')) {
    function computePercentage($number)
    {
        return $number . '%';
    }
}
if (!function_exists('getLoan')) {
    function getLoan($loan, $duration)
    {
        return $loan / ($duration * 2);
    }
}

if (!function_exists('getSalaryGradesTotalSteps')) {

    function getSalaryGradesTotalSteps()
    {
        $total_steps = 0;
        $temp = 0;
        foreach (SalaryGrade::all() as $key => $salary_grade) {
            $temp =  count($salary_grade->steps);
            if ($temp > $total_steps) {
                $total_steps = $temp;
            }
            $temp =  $total_steps;
        }

        return $total_steps;
    }
}
if (!function_exists('attendanceCount')) {

    function attendanceCount($employee, $payroll, $from, $to) {
        $month = date('m', strtotime($payroll['month']));
        $year = date('Y', strtotime($payroll['year']));
        $lastDayOfTheMonth = $to;
        if (!checkdate($month, $to, $year)) {
            $lastDayOfTheMonth = date('t', mktime(0, 0, 0, $month, 1, $year)); // get last day of the month
        }

        $total_man_hour = 0;
        $attendances = [];

        $loopEnd = ($to == 15) ? $lastDayOfTheMonth : $from;
        $loopStart = ($to == 15) ? $from : 15;

        // dd($loopEnd, $loopStart, $lastDayOfTheMonth);
        $from = sprintf('%04d-%02d-%02d', $year, $month, $from);
        $to = sprintf('%04d-%02d-%02d', $year, $month, $to);


        $from = Carbon::parse($from)->format('Y-m-d'); // Assuming 1st day of the month
        $to = Carbon::parse($to)->format('Y-m-d'); // Use $to for the last day

        for ($i = $loopStart; $i <= $loopEnd; $i++) {
          $day = str_pad($i, 2, '0', STR_PAD_LEFT);
          $attendance = $employee->attendances()
            ->whereMonth('time_in', $month)
            ->whereYear('time_in', $year)
            ->whereDay('time_in', $day)
            ->where('isPresent', 1)
            ->first();

          if ($attendance) {

            $timeIn = Carbon::parse($attendance->time_in);
            $manhours = $attendance->hours;
            $timeInInterval = '';
            $timeOutInterval = Carbon::parse('17:00');

            // Define time in interval based on different scenarios
            if ($timeIn->between(Carbon::parse('6:59'), Carbon::parse('7:11'))) {
              $timeInInterval = Carbon::parse('7:00');
            } elseif ($timeIn->between(Carbon::parse('7:11'), Carbon::parse('7:40'))) {
              $timeInInterval = Carbon::parse('7:30');
            } else {
              $timeInInterval = Carbon::parse('8:00');
            }

            // Consider weekends and employee category
            $isWeekend = (Carbon::parse($payroll['month'] . '-' . $day))->isWeekend();
            if ($isWeekend && $employee->category !== 'JO') {
              $attendances[$i] = [
                'day' => $day,
                'time_in' => '',
                'time_in_interval' => '',
                'time_out' => '',
                'time_out_interval' => '',
                'manhours' => 0, // No manhours for weekends (except JO)
              ];
            } else {
              $attendances[$i] = [
                'day' => $day,
                'time_in' => $attendance->time_in,
                'time_in_interval' => $timeInInterval,
                'time_out' => $attendance->time_out,
                'time_out_interval' => $timeOutInterval,
                'deduction' => $attendance->deduction,
                'manhours' => $manhours,
              ];
              $total_man_hour += $manhours;
            }
          } else {
            // Absent day details
            $attendances[$i] = [
              'day' => $day,
              'time_in' => '',
              'time_in_interval' => '',
              'time_out' => '',
              'time_out_interval' => '',
              'manhours' => '',
            ];
          }
        }

        return [
            'present' => $employee->attendances()->whereBetween('time_in', [$from , $to])->where('isPresent', 1)->count(),
            'absent' => $employee->attendances()->whereBetween('absent_at', [$from , $to])->where('isPresent', 0)->count(),
            'late' => $employee->attendances()->whereBetween('time_in', [$from , $to])->where('time_out_status', 'Under-time')->count(),
            'under_time' => $employee->attendances()->whereBetween('time_in', [$from , $to])->where('time_out_status', 'Under-time')->count(),
            'total_man_hour' => $total_man_hour,
            'attendances' => $attendances,
        ];
    }
}
if (!function_exists('getTotalSalaryBy')) {

    function getTotalSalaryBy(string $filter)
    {
        $totalSalaries = 0;
        $attendances = Attendance::with('employee')->get();
        $totalSalary = [];

        if ($filter == 'year') {
            // Group attendances by year
            $attendancesByYear = $attendances->groupBy(function ($attendance) {
                return $attendance->created_at->format('Y');
            });

            foreach ($attendancesByYear as $year => $attendances) {
                $total = $attendances->sum('salary');
                $totalSalaries += $total;
                $totalSalary[] = [
                    'year' => $year,
                    'total' => $total,
                ];
            }
        } else {
            // Group attendances by month
            $attendancesByMonth = $attendances->groupBy(function ($attendance) {
                return $attendance->created_at->format('F');
            });

            foreach ($attendancesByMonth as $month => $attendances) {
                $total = $attendances->sum('salary');
                $totalSalaries += $total;
                $totalSalary[] = [
                    'month' => $month,
                    'total' => $total,
                ];
            }
        }

        return collect($totalSalary);
    }
}
if (!function_exists('getTotalSalaryTest')) {

    function getTotalSalaryTest(string $filter)
    {
        $totalSalary = [];

        if ($filter == 'year') {

            for ($i = 1; $i <= 7; $i++) {
                $totalSalary[] = [
                    'year' => "202{$i}",
                    'total' => random_int(1, 100),
                ];
            }
        } else {
            for ($i = 1; $i <= 12; $i++) {
                $totalSalary[] = [
                    'month' => $i,
                    'total' => random_int(1, 100),
                ];
            }
        }

        return collect($totalSalary);
    }
}
if (!function_exists('countAttendanceBy')) {

    function countAttendanceBy(string $filter, ?int $value = null)
    {
        $attendances = Attendance::query();
        $seminar = Seminar::query();

        if ($filter == 'year') {
            $attendances->whereYear('created_at', $value);
        }
        $seminar->whereYear('date', $value);
        if ($filter == 'month') {
            $attendances->whereMonth('created_at', $value);
            $seminar->whereMonth('date', $value);
        }

        $attendancesData = $attendances->get();
        $seminarCount = $seminar->count();

        $present = -$attendancesData->where('isPresent', 1)->count();
        $absent = -$attendancesData->whereNull('time_out')->where('isPresent', 0)->count();
        $late = -$attendancesData->where('time_in_status', 'Late')->where('isPresent', 1)->count();
        $under_time = -$attendancesData->where('time_out_status', 'Under-time')->where('isPresent', 1)->count();
        $half_day = -$attendancesData->where('time_in_status', 'Half-Day')->where('isPresent', 1)->count();



        return collect([
            [
                'label' =>  'Present',
                'count' => $present
            ],
            [
                'label' =>  'Absent',
                'count' => $absent
            ],
            [
                'label' =>  'Late',
                'count' => $late
            ],
            [
                'label' =>  'Under Time',
                'count' => $under_time
            ],
            [
                'label' =>  'Half Day',
                'count' => $half_day
            ],
            [
                'label' =>  'Seminar',
                'count' => $seminarCount
            ],

        ]);
    }
}
if (!function_exists('countAttendancesTest')) {

    function countAttendancesTest()
    {

        return collect([
            [
                'label' =>  'Present',
                'count' => random_int(1, 100)
            ],
            [
                'label' =>  'Absent',
                'count' => random_int(1, 100)
            ],
            [
                'label' =>  'Late',
                'count' => random_int(1, 100)
            ],
            [
                'label' =>  'Under Time',
                'count' => random_int(1, 100)
            ],
            [
                'label' =>  'Half Day',
                'count' => random_int(1, 100)
            ],
            [
                'label' =>  'Seminar',
                'count' => random_int(1, 100)
            ],

        ]);
    }
}
if (!function_exists('getTotalSalaryDepartment')) {

    function getTotalSalaryDepartment($employeesData, $filterBy, $filter)
    {
        $totalSalary = 0;
        if (!empty($employeesData)) {
            foreach ($employeesData as $key => $employeeData) {
                if ($employeeData->employee->attendances) {
                    $attendances = $employeeData->employee->attendances()
                        ->whereYear('time_in', $filter)
                        ->get();
                    if ($filterBy == 'month') {
                        $attendances = $employeeData->employee->attendances()
                            ->whereMonth('time_in', $filter)
                            ->get();
                    }

                    // Sum up the allowance amounts
                    foreach ($attendances as $attendance) {
                        $totalSalary += $attendance->salary;
                    }
                }
            }
        }

        return $totalSalary;
    }
}
