<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $employee = Employee::where('employee_number', $row['userid'])->first();
    
        if ($employee) {
            $checkTime = Carbon::parse($row['checktime'], 'Asia/Manila');
            $checkType = $row['checktype'];
    
            $attendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('time_in', $checkTime->toDateString())
                ->first();
    
            if ($checkType == 'I') {
                // Time In
                if (!$attendance) {
                    $this->takeAttendance(true, $employee, $checkTime);
                }
            } elseif ($checkType == 'O') {
                // Time Out
                if ($attendance && $attendance->time_out === null) {
                    $this->takeAttendance(false, $employee, Carbon::parse($attendance->time_in), $checkTime);
                }
            }
        }
    }
    
    private function takeAttendance($isTimeIn, $employee, $timeIn, $timeOut = null)
    {
        $status = '';
        $timezone = 'Asia/Manila';
    
        // Set Carbon timezone globally
        Carbon::setToStringFormat('Y-m-d H:i:s');
    
        // Default times
        $defaultTimeIn = Carbon::parse('08:00:00', $timezone);
        $defaultTimeOut = Carbon::parse('17:00:00', $timezone);
    
        if ($isTimeIn) {
            // Time In logic
            if ($timeIn->greaterThanOrEqualTo($defaultTimeIn)) {
                $status = 'On-time';
            } elseif ($timeIn->greaterThan(Carbon::parse('10:00:00', $timezone))) {
                $status = 'Half-Day';
            } else {
                $status = 'Late';
            }
    
            $deduction = 0;
            if ($status !== 'On-time') {
                $minuteLate = $defaultTimeIn->diffInMinutes($timeIn);
                $deduction = $this->getLateByMinutes($minuteLate);
            }
    
            Attendance::create([
                'employee_id' => $employee->id,
                'time_in_status' => $status,
                'time_in' => $timeIn,
                'time_in_deduction' => $deduction,
            ]);
    
        } else {
            // Time Out logic
            $attendance = $employee->attendances()->whereDate('time_in', $timeIn->toDateString())->first();
    
            if ($attendance && $attendance->time_out === null) {
                // Calculate salary and update attendance
                $results = calculateSalary($employee->data->monthly_salary, $employee, $attendance, $defaultTimeIn, $defaultTimeOut, $timeOut, $employee->data->category->category_code == "JO");
    
                $attendance->update([
                    'time_out_status' => $results['status'],
                    'time_out' => $timeOut,
                    'hours' => $results['hour_worked'],
                    'salary' => $results['salary'],
                    'isPresent' => 1,
                    'time_out_deduction' => $results['deduction'],
                ]);
            }
        }
    
        return $status;
    }
    

    private function computeSickLeave($sick_leave, $minute_late)
    {
        $sick_leave_left = 0;

        // Compute the sick leave deduction per minute
        $sick_leave_left = $sick_leave - $this->getLateByMinutes($minute_late);

        // check if sick_leave_left is less than 0
        if ($sick_leave_left < 0) {
            $sick_leave_left = 0;
        }

        return $sick_leave_left;
    }
    private function getLateByMinutes($minute_late)
    {
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
        if (array_key_exists($minute_late, $equivalentMinutes)) {
            return $equivalentMinutes[$minute_late];
        } else {
            return 0;
        }
    }
    // private function determineStatus($checkTime, $isTimeIn, $employee)
    // {
    //     $timeIn = Carbon::parse('08:00:00', 'Asia/Manila');
    //     $timeOut = Carbon::parse('17:00:00', 'Asia/Manila');
    //     $tenAMThreshold = Carbon::parse('10:00:00', 'Asia/Manila');
    //     if ($isTimeIn) {
    //         if ($checkTime->lessThanOrEqualTo($timeIn)) {
    //             return 'On-time';
    //         } elseif ($checkTime->greaterThanOrEqualTo($tenAMThreshold)) {
    //             return 'Half-Day';
    //         } else {
    //             return 'Late';
    //         }
    //     }
    //     if ($checkTime < $timeOut) {
    //         if ($employee->data->category->category_code == "JO" ||  $employee->data->category->category_code == "COS") {
    //             return 'Half-Day';
    //         } else {
    //             return 'Under-time';
    //         }
    //     } else {
    //         return 'Time-out';
    //     }
    // }

    // private function calculateDeduction($checkTime, $employee)
    // {
    //     $timeIn = Carbon::parse('08:00:00', 'Asia/Manila');
    //     $minute_late = $timeIn->diffInMinutes($checkTime);

    //     if ($employee->data->category->category_code == "JO" || $employee->data->sick_leave_points == 0) {
    //         return 0;
    //     }

    //     return $this->getLateByMinutes($minute_late);
    // }

    // private function getLateByMinutes($minute_late)
    // {
    //     $equivalentMinutes = [
    //         1 => 0.002, 2 => 0.004, 3 => 0.006, 4 => 0.008, 5 => 0.010,
    //         6 => 0.012, 7 => 0.014, 8 => 0.017, 9 => 0.019, 10 => 0.021,
    //         11 => 0.023, 12 => 0.025, 13 => 0.027, 14 => 0.029, 15 => 0.031,
    //         16 => 0.033, 17 => 0.035, 18 => 0.037, 19 => 0.040, 20 => 0.042,
    //         21 => 0.044, 22 => 0.046, 23 => 0.048, 24 => 0.050, 25 => 0.052,
    //         26 => 0.054, 27 => 0.056, 28 => 0.058, 29 => 0.060, 30 => 0.062,
    //         31 => 0.065, 32 => 0.067, 33 => 0.069, 34 => 0.071, 35 => 0.073,
    //         36 => 0.075, 37 => 0.077, 38 => 0.079, 39 => 0.081, 40 => 0.083,
    //         41 => 0.085, 42 => 0.087, 43 => 0.090, 44 => 0.092, 45 => 0.094,
    //         46 => 0.096, 47 => 0.098, 48 => 0.100, 49 => 0.102, 50 => 0.104,
    //         51 => 0.106, 52 => 0.108, 53 => 0.110, 54 => 0.112, 55 => 0.114,
    //         56 => 0.117, 57 => 0.119, 58 => 0.121, 59 => 0.123, 60 => 0.125
    //     ];
    //     return $equivalentMinutes[$minute_late] ?? 0;
    // }

    // private function calculateSalary($hours, $employee)
    // {
    //     $salary_grade = $employee->data->monthly_salary;
    //     // Implement your salary calculation logic here based on $hours and $salary_grade
    //     return $salary_grade / 160 * $hours; // Example calculation
    // }
}