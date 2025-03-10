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
if (!function_exists('getMonthsFromAttendance')) {
    function getMonthsFromAttendance($employee)
    {

        return Attendance::selectRaw('MONTH(time_in) as month, MIN(time_in) as earliest_time_in')
            ->where('isPresent', 1)
            ->where('employee_id', $employee->id)
            ->whereYear('time_in', now()->format('Y'))
            ->groupByRaw('MONTH(time_in)')
            ->orderByRaw('MONTH(time_in)')
            ->get();
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
if (!function_exists('getLate')) {
    function getLate($time, $isFormatted)
    {
        $timeIn = Carbon::parse(date('H:i:s', strtotime($time)));
        $now = Carbon::parse('08:00:00');
        $minute_late = $now->diffInMinutes($timeIn);
        $late = '';

        if ($isFormatted) {
            if ($minute_late >= 60) {
                return floor($minute_late / 60) . " hr " . ($minute_late % 60) . " mins";
            } else {
                return $minute_late % 60 . " mins";
            }
        }

        return $minute_late % 60 . " mins";
    }
}
if (!function_exists('getInterval')) {

    function getInterval($time, $isTimeIn, $isFormatted)
    {
        $time = Carbon::parse(date('H:i:s', strtotime($time)));
        // dd($time);
        if ($isTimeIn) {
            if ($time->between(Carbon::parse('6:00:00'), Carbon::parse('8:00:00'))) {
                $interval = Carbon::parse('8:00:00');
            } elseif ($time->between(Carbon::parse('8:01:00'), Carbon::parse('9:00:00'))) {
                $interval = Carbon::parse('9:00:00');
            } elseif ($time->between(Carbon::parse('9:01:00'), Carbon::parse('10:00:00'))) {
                $interval = Carbon::parse('10:00:00');
            } elseif ($time->between(Carbon::parse('10:01:00'), Carbon::parse('11:00:00'))) {
                $interval = Carbon::parse('11:00:00');
            } elseif ($time->between(Carbon::parse('11:01:00'), Carbon::parse('12:00:00'))) {
                $interval = Carbon::parse('12:00:00');
            } else {
                $interval = Carbon::parse('12:00:00');
            }
        } else {
            if ($time->between(Carbon::parse('13:00:00'), Carbon::parse('14:00:00'))) {
                $interval = Carbon::parse('14:00:00');
            } elseif ($time->between(Carbon::parse('14:01:00'), Carbon::parse('15:00:00'))) {
                $interval = Carbon::parse('15:00:00');
            } elseif ($time->between(Carbon::parse('15:01:00'), Carbon::parse('16:49:00'))) {
                $interval = Carbon::parse('16:00:00');
            } else {
                $interval = Carbon::parse('17:00:00');
            }
        }


        if ($isFormatted) {
            return $interval->format('h:i:s A');
        }
        return $interval;
    }
}
if (!function_exists('attendanceCount')) {

        function attendanceCount($employee, $month, $year, $from, $to, $isMonthly = false)
        {
            $month = date('m', strtotime($month));
            $year = date('Y', strtotime($year));
            $lastDayOfTheMonth = checkdate($month, $to, $year) ? $to : date('t', mktime(0, 0, 0, $month, 1, $year));

            $total_man_hour = $total_salary = $present = $absent = $late = $underTime = $totalUnderTimeHours = $totalUnderTimeMinutes = $halfday = 0;
            $attendances = [];
            $loopStart = $isMonthly ? 1 : ($to == 15 ? 1 : 16);
            $loopEnd = $isMonthly ? $lastDayOfTheMonth : ($to == 15 ? 15 : $lastDayOfTheMonth);

            $from = Carbon::parse(sprintf('%04d-%02d-%02d', $year, $month, $from))->format('Y-m-d');
            $to = Carbon::parse(sprintf('%04d-%02d-%02d', $year, $month, $loopEnd))->format('Y-m-d');

            for ($i = $loopStart; $i <= $loopEnd; $i++) {
                $date = Carbon::parse(sprintf('%04d-%02d-%02d', $year, $month, str_pad($i, 2, '0', STR_PAD_LEFT)));
                $attendance = $employee->attendances()->whereDate('time_in', $date)->where('isPresent', 1)->first();
                $isWeekend = $date->isWeekend();
                $dateFormatted = $date->format('Y-m-d');

                if ($attendance) {
                    $timeOut = Carbon::parse($attendance->time_out);
                    $startTime = Carbon::parse($timeOut->format('Y-m-d') . ' 08:00:00');
                    $manhours = $timeOut->diffInHours($startTime) - 1;
                    if ($attendance->time_in_status == 'Half-Day' || $attendance->time_out_status == 'Half-Day') {
                        $manhours = ($employee->data->category->category_code === 'JO' || $employee->data->category->category_code === 'COS') ? 4 : $manhours;
                    }
                    $timeInInterval = getInterval($attendance->time_in, true, true);
                    $timeOutInterval = getInterval($attendance->time_out, false, true);

                    if ($isWeekend && $employee->data->category->category_code !== 'JO' && $attendance->type !== 'seminar') {
                        $attendances[$i] = [
                            'day' => $isMonthly ? date('d', strtotime($dateFormatted)) : date('d', strtotime($dateFormatted)) . '-' . Str::substr(date('l', strtotime($dateFormatted)), 0, 3),
                            'time_in' => '',
                            'time_in_interval' => '',
                            'time_out' => '',
                            'time_out_interval' => '',
                            'manhours' => '',
                            'under_time_hours' => 0,
                            'under_time_minutes' => 0,
                            'isWeekend' => $isWeekend,
                            'color' => '',
                        ];
                    } else {
                        $under_time_hours = $under_time_minutes = 0;
                        if ($attendance->time_out_status == 'Under-time') {
                            $underTime++;
                            $defaultTimeOut = Carbon::parse('17:00:00');
                            $formattedTimeOut = Carbon::parse($attendance->time_out)->format('H:i:s');
                            $underTimeMinutes = $defaultTimeOut->diffInMinutes($formattedTimeOut);

                            $under_time_hours = ($underTimeMinutes > 60) ? $defaultTimeOut->diffInHours($formattedTimeOut) : 0;
                            $under_time_minutes = ($underTimeMinutes > 60) ? 0 : $underTimeMinutes;
                            $totalUnderTimeHours += $under_time_hours;
                            $totalUnderTimeMinutes += $under_time_minutes;
                        }

                        $attendances[$i] = [
                            'day' => $isMonthly ? date('d', strtotime($dateFormatted)) : date('d', strtotime($dateFormatted)) . '-' . Str::substr(date('l', strtotime($dateFormatted)), 0, 3),
                            'time_in' => $attendance->time_in,
                            'time_in_interval' => $timeInInterval,
                            'time_in_status' => $attendance->time_in_status,
                            'time_out' => $attendance->time_out,
                            'time_out_status' => $attendance->time_out_status,
                            'time_out_interval' => $timeOutInterval,
                            'deduction' => $attendance->time_in_deduction + $attendance->time_out_deduction,
                            'manhours' => $manhours,
                            'total_salary' => $attendance->salary,
                            'under_time_hours' => $under_time_hours,
                            'under_time_minutes' => $under_time_minutes,
                            'isWeekend' => $isWeekend,
                            'color' => getColor($attendance->type),
                        ];

                        if ($attendance->time_in_status == 'Late') $late++;
                        if ($attendance->time_in_status == 'Half-Day' || $attendance->time_out_status == 'Half-Day') $halfday++;
                        $total_man_hour += $manhours;
                        $total_salary += $attendance->salary;
                        $present++;
                    }
                } else {
                    if (!$isWeekend || $employee->category == 'JO') $absent++;
                    $attendances[$i] = [
                        'day' => $isMonthly ? date('d', strtotime($dateFormatted)) : date('d', strtotime($dateFormatted)) . '-' . Str::substr(date('l', strtotime($dateFormatted)), 0, 3),
                        'time_in' => '',
                        'time_in_interval' => '',
                        'time_out' => '',
                        'time_out_interval' => '',
                        'manhours' => '',
                        'under_time_hours' => 0,
                        'under_time_minutes' => 0,
                        'color' => '',
                    ];
                }
            }

            return [
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
                'under_time' => $underTime,
                'halfday' => $halfday,
                'total_man_hour' => $total_man_hour,
                'total_salary' => $total_salary,
                'totalUnderTimeHours' => $totalUnderTimeHours,
                'totalUnderTimeMinutes' => $totalUnderTimeMinutes,
                'attendances' => $attendances,
            ];
        }
}
if (!function_exists('calculateSalary')) {

    function calculateSalary($salaryGrade, $employee, $attendance, $timeIn, $timeOut, $currentTime, $isJO)
    {
        // Default working days and hours
        $isCOS = $employee->data->category->category_code == "COS";
        $workingDays = 15;
        $requiredHoursWork = 8;
        $deduction = 0;
        $hourWorked = 0;
        $sickLeave = 0;

        // Carbon instances for attendance and defaults
        $attendanceTimeIn = Carbon::parse(date('H:i:s', strtotime($attendance->time_in)));
        $attendanceTimeOut = Carbon::parse(date('H:i:s', strtotime($currentTime)));
        $formattedTimeIn = $attendanceTimeIn->copy()->format('H:i:s');
        $formattedTimeout = $attendanceTimeOut->copy()->format('H:i:s');

        $defaultTimeIn = Carbon::parse($timeIn);
        $defaultTimeOut = Carbon::parse($timeOut);
        $formattedDefaultTimeIn = $defaultTimeIn->copy()->format('H:i:s');
        $formattedDefaultTimeOut = $defaultTimeOut->copy()->format('H:i:s');

        // Calculate hours worked, handling negative values and exceeding 8 hours
        if ($formattedTimeIn <= $formattedDefaultTimeIn) {
            // early 8am
            if ($formattedTimeout < $formattedDefaultTimeOut) {
                // undertime
                if ($isJO ||  $isCOS) {
                    $status = 'Half-Day';
                } else {
                    $status = 'Under-time';
                }
            } else {
                $status = 'Time-out';
            }
        } else {
            // lates
            if ($formattedTimeout < $formattedDefaultTimeOut) {
                // undertime
                if ($isJO ||  $isCOS) {
                    $status = 'Half-Day';
                } else {
                    $status = 'Under-time';
                }
            } else {
                $status = 'Time-out';
            }
        }
        $hourWorked = $defaultTimeIn->diffInHours($attendanceTimeOut, true) - 1;

        if ($hourWorked < 0) {
            $hourWorked =  0;
        }

        // Calculate minutes late
        $minutesLate = $attendanceTimeIn->diffInMinutes($attendanceTimeIn);
        if (!$isJO) {
            $salaryPerHour = ($salaryGrade / 22) / $requiredHoursWork;
            if ($isCOS) {
                if ($attendance->time_in_status === 'Half-Day' || ($status === 'Half-Day' || $status === 'Under-time')) {
                    $totalSalaryForToday = ($salaryGrade / 22) / 2;
                } else {
                    $totalSalaryForToday = $salaryGrade / 22;
                }
            }

            // Deduct sick leave points only if the status is Late, Half-Day, or Under-time
            if ($attendance->time_in_status === 'Late' || $status === 'Half-Day' || $status === 'Under-time') {
                $sickLeave = $employee->data->sick_leave_points;
                if ($sickLeave > 0) {
                    $sickLeave = computeSickLeave($sickLeave, $minutesLate);
                }
            }
        }

        if (!$isJO && !$isCOS) {
            $totalSalaryForToday = ($salaryPerHour * $hourWorked);
            $totalSalaryForToday = ($totalSalaryForToday > 0) ? $totalSalaryForToday : 0;
            $deduction = 0;
            if($attendance->time_in_status === 'Late' || $attendance->time_in_status === 'Half-Day'){
                $deduction = $deduction + $attendance->time_in_deduction;
            }
            // Deduct sick leave points only if the status is Late, Half-Day, or Under-time
            if ($status === 'Half-Day' || $status === 'Under-time') {
                $notWorkedHour = $defaultTimeOut->diffInHours($attendanceTimeOut);
                $minutes = $defaultTimeOut->diffInMinutes($attendanceTimeOut);
                $deduction = $deduction + ($notWorkedHour * getLateByMinutes($minutes));
                // $sickLeave = $sickLeave - $deduction;
                if ($employee->data->sick_leave_points <= 0) {
                    $salaryPerHour = $salaryPerHour - $notWorkedHour;
                    $sickLeave = 0;
                    $deduction = 0;
                }
            }
            $employee->data->update(['sick_leave_points' => $sickLeave]);
        } else {
            if ($isJO) {
                $totalSalaryForToday = $salaryGrade;
                if ($attendance->time_in_status === 'Half-Day' || ($status === 'Half-Day' || $status === 'Under-time')) {
                    $totalSalaryForToday = $salaryGrade / 2;
                }
            }
        }

        return [
            'salary' => $totalSalaryForToday,
            'status' => $status,
            'hour_worked' => $hourWorked,
            'deduction' => $deduction,
        ];
    }
}
if (!function_exists('computeSickLeave')) {

    function computeSickLeave($sick_leave, $minute_late)
    {
        $sick_leave_left = 0;

        // Compute the sick leave deduction per minute
        $sick_leave_left = $sick_leave - getLateByMinutes($minute_late);

        // check if sick_leave_left is less than 0
        if ($sick_leave_left < 0) {
            $sick_leave_left = 0;
        }

        return $sick_leave_left;
    }
}
if (!function_exists('getLateByMinutes')) {

    function getLateByMinutes($minute_late)
    {
        $maxMinutesPerHour = 60;
        $equivalentPerHour = 0.125; // Equivalent per minute based on your logic (0.125 for whole hour)
        $equivalentMinutes = [
            1 => 0.002, 2 => 0.004, 3 => 0.006, 4 => 0.008, 5 => 0.010,
            6 => 0.012, 7 => 0.014, 8 => 0.017, 9 => 0.019, 10 => 0.021,
            11 => 0.023, 12 => 0.025, 13 => 0.027, 14 => 0.029, 15 => 0.031,
            16 => 0.033, 17 => 0.035, 18 => 0.037, 19 => 0.040, 20 => 0.042,
            21 => 0.044, 22 => 0.046, 23 => 0.048, 24 => 0.050, 25 => 0.052,
            26 => 0.054, 27 => 0.056, 28 => 0.058, 29 => 0.060, 30 => 0.062,
            31 => 0.065, 32 => 0.067, 33 => 0.069, 34 => 0.071, 35 => 0.073,
            36 => 0.075, 37 => 0.077, 38 => 0.079, 39 => 0.081, 40 => 0.083,
            41 => 0.085, 42 => 0.087, 43 => 0.090, 44 => 0.092, 45 => 0.094,
            46 => 0.096, 47 => 0.098, 48 => 0.100, 49 => 0.102, 50 => 0.104,
            51 => 0.106, 52 => 0.108, 53 => 0.110, 54 => 0.112, 55 => 0.114,
            56 => 0.117, 57 => 0.119, 58 => 0.121, 59 => 0.123, 60 => 0.125
        ];

        $hourLate = (int) floor($minute_late / $maxMinutesPerHour);
        $remainingMinutes = $minute_late % $maxMinutesPerHour;

        $equivalent = $hourLate * $equivalentPerHour;
        if ($remainingMinutes > 0) {
            $equivalent += $equivalentMinutes[$remainingMinutes];
        }

        return $equivalent;
    }
}
if (!function_exists('getDatesBetween')) {

    function getDatesBetween($startDate, $endDate, $returnDates, $includeGap = false)
    {
        $dates = [];
        $currentDate = strtotime($startDate);
        $days = 0;
        while ($currentDate <= strtotime($endDate)) {
            $dayOfWeek = date('w', $currentDate); // Get the day of the week (0 for Sunday)

            // Skip Saturdays (dayOfWeek == 6) and Sundays (dayOfWeek == 0)
            if ($dayOfWeek != 6 && $dayOfWeek != 0) {
                $dates[] = date('Y-m-d', $currentDate);
                $days++;
            }

            // Add 1 day gap if the flag is set
            $currentDate = $includeGap ? strtotime('+2 days', $currentDate) : strtotime('+1 day', $currentDate);
        }
        if ($returnDates) {
            return $dates;
        }
        return $days;
    }
}

if (!function_exists('getColor')) {

    function getColor($type = '', $returnAllColors = false)
    {
        $colors = [
            'seminar' => '#055100',
            'travel_order' => '#db1d8e',
            'maternity_leave' => '#000baa',
            'vacation_leave' => '#360723',
            'sick_leave' => '#a00',
            'force_leave' => '#a42c00',
        ];

        if ($returnAllColors) {
            return $colors;
        }
        // Return the color associated with the type, or a default color if not found
        return array_key_exists($type, $colors) ? $colors[$type] : ''; // Default gray
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
if (!function_exists('computeAnnualTaxableCompensation')) {

    function computeAnnualTaxableCompensation($monthly_salary, $deductions)
    {
        // Calculate the 13th-month pay (if applicable)
        $thirteenthMonthPay = computeThirteenthMonthPay($monthly_salary);
        $AnnualContribution = $deductions * 12;
        //((MS * 12) + thirteenth month pay) - total deductions
        $annualTaxableCompensation = (($monthly_salary * 12) + $thirteenthMonthPay) - $AnnualContribution;
        if ($annualTaxableCompensation < 0) {
            return 0;
        }
        return $annualTaxableCompensation;
    }
}
if (!function_exists('computeThirteenthMonthPay')) {

    function computeThirteenthMonthPay($monthlySalary)
    {
        $thirteenMonthSalary = 0;
        $fixedAmount = 90000;
        // (MS * 2) - 90k
        $thirteenMonthSalary = ($monthlySalary * 2) -  $fixedAmount;
        if ($thirteenMonthSalary < 0) {
            return 0;
        }
        return $thirteenMonthSalary;
    }
}
if (!function_exists('computeTaxableCompensation')) {

    function computeTaxableCompensation($annualTaxableCompensation)
    {
        // below 250k
        if ($annualTaxableCompensation <= 250000) {
            $taxRate = 0;
            //250k pataas hanggang 400k
        } else if ($annualTaxableCompensation <= 400000) {
            $taxRate = 0.15 * ($annualTaxableCompensation - 250000);
        } else if ($annualTaxableCompensation <= 800000) {
            $taxRate = 22500 + (0.20 * ($annualTaxableCompensation - 400000));
        } else if ($annualTaxableCompensation <= 2000000) {
            $taxRate = 102500 + (0.25 * ($annualTaxableCompensation - 800000));
        } else if ($annualTaxableCompensation <= 8000000) {
            $taxRate = 402500 + (0.30 * ($annualTaxableCompensation - 2000000));
        } else {
            $taxRate = 2202500 + (0.35 * ($annualTaxableCompensation - 8000000));
        }
        if ($taxRate < 0) {
            return 0;
        }
        return $taxRate;
    }
}
if (!function_exists('computeHoldingTax')) {

    function computeHoldingTax($monthlySalary, $deductions)
    {
        $annualTaxableCompensation = computeAnnualTaxableCompensation($monthlySalary, $deductions);
        $annualTaxDue = computeTaxableCompensation($annualTaxableCompensation);
        // dd(($annualTaxDue / 12) / 2, $annualTaxDue, $annualTaxableCompensation, $monthlySalary, $deductions);
        return ($annualTaxDue / 12) / 2;
    }
}

if (!function_exists('getHazard')) {

    function getHazard($salary_grade_id, $salary_grade)
    {
        if ($salary_grade_id < 19) {
            return $salary_grade * 0.25;
        }
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
if (!function_exists('isBetweenDatesOfLoan')) {

    function isBetweenDatesOfLoan($loan, $date)
    {
        $start_date = Carbon::parse($loan->start_date);
        $end_date = Carbon::parse($loan->end_date);
        $date = Carbon::parse($date);
        // dd($date, $start_date, $end_date, $date->between($start_date, $end_date));
        return $date->between($start_date, $end_date);
    }
}
