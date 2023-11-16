<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Sgrade;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of payroll records.
     */
    public function index($department_id = null)
    {
        try {
            // Retrieve all payroll records from the database
            // get all the departments
            $employee_departments = Department::query()->whereHas('employees')->distinct('dep_name');
            if ($department_id) {
                $employee_departments->where('id', $department_id);
            }
            $employee_departments = $employee_departments->get();

            // get all the months in attendance and sort it
            // Get all unique months from the created_at column and sort them
            $months = Attendance::orderBy('created_at')
                ->distinct('month')
                ->get();


            $payrolls = $this->getPayroll($employee_departments, $months);
            // dd($payrolls, $employee_departments, $months);
            $departments = Department::all();
            // Other code to retrieve the payrolls

            // Pass the payroll records to the view
            return view('payrolls.index', compact('departments', 'payrolls'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new payroll record.
     */
    private function getPayroll($departments, $months)
    {
        $payrolls = [];
        $fromTo = ['1-15', '16-31'];

        foreach ($departments as $department) {
            foreach ($months as $month) {
                foreach ($fromTo as $itemDay) {
                    $day = $month->created_at->day;

                    // Check if the day falls within the specified range
                    $isInRange = ($itemDay == '1-15' && $day >= 1 && $day <= 15) ||
                        ($itemDay == '16-31' && $day >= 16 && $day <= 31);

                    if ($isInRange) {
                        // Create a unique key for the payroll record
                        $uniqueKey = "{$department->id}_{$month->month}_{$itemDay}";

                        // Only create a new payroll record if it doesn't exist
                        if (!isset($payrolls[$uniqueKey])) {
                            $payrolls[$uniqueKey] = [
                                'department_id' => $department->id,
                                'department' => $department->dep_name,
                                'month' => date('F', strtotime($month->created_at)),
                                'year' => date('Y',strtotime($month->created_at)),
                                'date_from_to' => $itemDay,
                            ];
                        }
                    }
                }
            }
        }
        return $payrolls;
    }

    // $uniqueKey = "{$department->id}_{$month->month}_{$itemDay}";
    // if (!isset($payrolls[$uniqueKey])) {
    //     $payrolls[$uniqueKey] = [
    //         'department_id' => $department->id,
    //         'department' => $department->dep_name,
    //         'month' => date('F', strtotime($month->created_at)),
    //         'year' => date('Y'),
    //         'date_from_to' => $itemDay,
    //     ];
    // }

    public function create()
    {
        $departments = Department::all();

        return view('payrolls.create', compact('departments'));
    }

    /**
     * Store a newly created payroll record in the database.
     */
    public function store(Request $request)
    {
        $payroll = new Payroll([
            'pr_department' => $request->pr_department,
            'month' => $request->month,
            'year' => $request->year,
            'date_from_to' => $request->date_from_to,
        ]);
        $payroll->save();

        return redirect()->route('payrolls.index')->with('success', 'Payroll record created successfully.');
    }

    /**
     * Display the specified payroll record.
     */
    public function show($payroll)
    {
        $payroll = json_decode(urldecode($payroll), true);
        $employees = Department::find($payroll['department_id'])->employees;
        // Pass the payroll record to the view
        return view('payrolls.show', compact('payroll', 'employees'));
    }
    public function dtr($id, $payroll)
    {
        $payroll = json_decode(urldecode($payroll), true);
        $dates = explode('-', $payroll['date_from_to']);
        $from = $dates[0];
        $to = $dates[1];

        $employee = Employee::find($id);
        $presents = $employee->countAttendance('present', $payroll['month'], $payroll['year'], $from, $to);
        $absents = $employee->countAttendance('absent', $payroll['month'], $payroll['year'], $from, $to);
        $lates = $employee->countAttendance('late', $payroll['month'], $payroll['year'], $from, $to);
        $undertimes = $employee->countAttendance('undertime', $payroll['month'], $payroll['year'], $from, $to);
        $hours = $employee->countAttendance('manhours', $payroll['month'], $payroll['year'], $from, $to);

        // initialize array of attendance records base on from and to, fill the array if the day of emplyoee atttendance is equal to day in array
        $attendances = [];
        $totalManHour = 0;
        $day = ($from < 10) ? '0' . $from : $from;
        $loopEnd = ($to == 31) ? $from : $to;
        for ($i = 1; $i <= $loopEnd; $i++) {

            // get attendance for that day from created_at
            $attendance = $employee->attendances()->whereDay('created_at', $day)->first();
            if ($attendance) {
                $timeIn = Carbon::parse($attendance->time_in);
                $manhours = $attendance->hours;
                $timeInInterval = '';
                $timeOutInterval = Carbon::parse('17:00');
                if ($timeIn->between(Carbon::parse('6:59'), Carbon::parse('7:11'))) {
                    $timeInInterval = Carbon::parse('7:00');
                } elseif ($timeIn->between(Carbon::parse('7:11'), Carbon::parse('7:40'))) {
                    $timeInInterval = Carbon::parse('7:30');
                } elseif ($timeIn->between(Carbon::parse('7:41'), Carbon::parse('8:11'))) {
                    $timeInInterval = Carbon::parse('8:00');
                }

                $attendances[$i] = [
                    'day' => $day,
                    'time_in' => $attendance->time_in,
                    'time_in_interval' => $timeInInterval,
                    'time_out' => $attendance->time_out,
                    'time_out_interval' => $timeOutInterval,
                    'manhours' => $manhours,
                ];
                $totalManHour += $manhours;
            }else{
                $attendances[$i] = [
                    'day' => $day,
                    'time_in' => '',
                    'time_in_interval' => '',
                    'time_out' => '',
                    'time_out_interval' => '',
                   'manhours' => '',
                ];
            }
            $day = ($day++ < 10) ? '0' . $day : $day;
        }


        // Pass the payroll record to the view
        return view('payrolls.dtr', compact('employee', 'attendances', 'presents', 'absents', 'lates', 'undertimes', 'payroll', 'totalManHour'));
    }

    /**
     * Show the form for editing the specified payroll record.
     */
    public function edit(Payroll $payroll)
    {
        return view('payrolls.edit', compact('payroll'));
    }

    /**
     * Update the specified payroll record in the database.
     */
    public function update(Request $request, Payroll $payroll)
    {
        $request->validate([
            'pr_department' => 'required',
            'month' => 'required',
            'year' => 'required',
            'date_from_to' => 'required',
        ]);

        $payroll->update($request->all());

        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll record updated successfully.');
    }

    /**
     * Remove the specified payroll record from storage.
     */
    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll record deleted successfully.');
    }

    public function generateSlip(Payroll $payroll)
    {
        // Pass the payroll record to the view
        return view('payrolls.generateSlip', compact('payroll'));
    }
}
