<?php

namespace App\Livewire\LeaveRequest;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeLeaveRequest;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public array $types;
    public int $employee_id;
    public  $employees;
    public Employee $employee;
    public string $name;
    public string $department;
    public  $start;
    public  $end;
    public $type;
    public $letter;
    public int $points = 0;
    public int $fl_points = 0;
    public int $sl_points = 0;
    public float $points_per_day = 1;
    public int $days = 0;
    public int $days_leave = 0;
    public bool $isAnyOfTheSelectedCategories = false;

    protected $rules = [
        'start' => 'required|after:today',
        'end' => 'required',
    ];
    protected $validationAttributes = [
        'start' => 'Start Date',
        'end' => 'End Date',
    ];
    public function updatedEmployeeId($value)
    {
        $this->isAnyOfTheSelectedCategories = false;
        $this->employee = Employee::find($value);
        $this->name = $this->employee->full_name;
        $this->department = $this->employee->data->department->dep_name;
        $this->points = ($this->employee->data->sick_leave_points) ? $this->employee->data->sick_leave_points : 0;
        // if ($this->points <= 0) {
        //     session()->flash('error', "Employee:" . $this->employee->full_name . " doesn`t have leave points");
        // }
        if ($this->employee->data->category->category_code == 'PERM' || $this->employee->data->category->category_code == 'COTERM' || $this->employee->data->category->category_code == 'CAS') {
            $this->isAnyOfTheSelectedCategories = true;
            $this->types = [
                'maternity_leave',
                'vacation_leave',
                'sick_leave',
                'force_leave',
                'special_leave',

            ];
        }
        $this->fl_points =  5 - Attendance::where('type', 'force_leave')->whereYear('created_at', now()->format('Y'))->count();
        $this->sl_points = 3 - Attendance::where('type', 'special_leave')->whereYear('created_at', now()->format('Y'))->count();
        // calculate the total days based on points
        $this->days =  $this->points;
    }
    public function updatedEnd($value)
    {
        if ($value) {
            $start = Carbon::parse($this->start);
            $end = Carbon::parse($this->end);
            //count the days between start and end
            $this->days_leave = getDatesBetween($start, $end, false);
            if (!$this->isAnyOfTheSelectedCategories) {
                if ($this->days_leave >= $this->days && $this->days_leave != $this->days) {
                    return session()->flash('error', 'The number of days exceeds the allowed limit.');
                }
            }
        }
    }

    public function save()
    {
        try {
            $this->validate();

            if ($this->checkIfEmployeeAlreadyAttendance()) {
                return session()->flash('error', 'Cannot add leave, employee already have an attendance record. Please try submitting leave for a different date.');
            }
            $leave_points = $this->points;
            if ($this->type == 'force_leave' || $this->type == 'special_leave') {
                if (($this->type == 'force_leave' && $this->days_leave >= $this->fl_points) || ($this->type == 'special_leave' && $this->days_leave >= $this->sl_points)) {
                    return session()->flash('error', 'The number of days exceeds the allowed limit.');
                }
            } else {
                if ($this->points <= 0) {
                    return session()->flash('error', "Employee:" . $this->employee->full_name . " doesn`t have leave points");
                }
                if ($this->days_leave >= $this->days && $this->days_leave != $this->days) {
                    return session()->flash('error', 'The number of days exceeds the allowed limit.');
                }
                $leave_points -= $this->days_leave;
            }
            $file_name = '';
            if ($this->isAnyOfTheSelectedCategories) {
                if (!$this->letter) {
                    return session()->flash('error', 'Please upload a letter for special leave.');
                }
                // Generate a new file name for the uploaded PDS
                $file_name = md5($this->letter->getClientOriginalName() . microtime()) . '.' . $this->letter->extension();

                // Store the new PDS in the 'public/pds' directory
                $this->letter->storeAs('public/letters', $file_name);
            }
            $leave_request = EmployeeLeaveRequest::create([
                'employee_id' => $this->employee->id,
                'start' => $this->start,
                'end' => $this->end,
                'type' => $this->type,
                'status' => 'accepted',
                'points' => $leave_points,
                'letter' => $file_name,
                'deducted_points' => ($this->type == 'force_leave' || $this->type == 'special_leave') ? 0 : $this->days_leave,
                'days' => $this->days_leave,
            ]);

            $this->takeAttendance($leave_request, getDatesBetween($leave_request->start, $leave_request->end, true));
            if ($this->type != 'force_leave' && $this->type != 'special_leave') {
                $leave_request->employee->data->update(['sick_leave_points' => ($leave_request->employee->data->sick_leave_points - ($this->points_per_day * $leave_request->days))]);
            }
            // Create activity
            createActivity('Create Employee Leave Request', 'Create Employee Leave Request for ' . $this->employee->full_name . '.', request()->getClientIp(true));

            // Redirect to the index page with a success message
            return redirect()->route('employees.show', $this->employee)->with('success', 'Leave Request created successfully.');
        } catch (\Throwable $th) {
            return session()->flash('error', $th->getMessage());
        }
    }
    public function takeAttendance($leave_request, $dates)
    {
        $salary_grade = $leave_request->employee->data->monthly_salary;
        $salary = $this->calculateSalary($salary_grade, $leave_request->employee->data->category);

        foreach ($dates as $key => $date) {
            $timeIn = $date . ' 08:00:00'; // Combine date with time in
            $timeOut = $date . ' 17:00:00'; // Combine date with time out
            Attendance::create([
                'employee_id' => $leave_request->employee->id,
                'time_in_status' => 'On-time',
                'time_in' => $timeIn,
                'time_out_status' => 'Time-out',
                'time_out' => $timeOut,
                'hours' => 8,
                'salary' =>   $salary,
                'type' =>   $leave_request->type,
                'isPresent' => 1,
            ]);
        }
    }
    public function calculateSalary($salaryGrade, $category)
    {
        if ($category->category_code == "JO") {
            return $salaryGrade;
        }
        if ($category->category_code == "COS") {
            return $salaryGrade / 22;
        }
        $salaryPerHour = ($salaryGrade / 22) / 8;
        return max(0, $salaryPerHour); // Ensure non-negative
    }
    public function checkIfEmployeeAlreadyAttendance()
    {
        $dates = getDatesBetween($this->start, $this->end, true);
        foreach ($dates as $key => $date) {
            $attendance = Attendance::whereDate('time_in', $date)->first();
            if ($attendance) {
                return true;
            }
        }
        return false;
    }
    public function mount(Employee $employee)
    {
        $this->employee = $employee;
        // dd($this->employee);
        $this->name = $this->employee->full_name;
        $this->department = $this->employee->data->department->dep_name;
        $this->points = ($this->employee->data->sick_leave_points) ? $this->employee->data->sick_leave_points : 0;
        $this->types = [
            'maternity_leave',
            'vacation_leave',
            'sick_leave',
            'force_leave'
        ];
        if ($this->employee->data->category->category_code == 'PERM' || $this->employee->data->category->category_code == 'COTERM' || $this->employee->data->category->category_code == 'CAS') {
            $this->isAnyOfTheSelectedCategories = true;
            $this->types = [
                'maternity_leave',
                'vacation_leave',
                'sick_leave',
                'force_leave',
                'special_leave'
            ];
        }
        $this->fl_points =  5 - Attendance::where('type', 'force_leave')->whereYear('created_at', now()->format('Y'))->count();
        $this->sl_points = 3 - Attendance::where('type', 'special_leave')->whereYear('created_at', now()->format('Y'))->count();
        // calculate the total days based on points
        $this->days =  $this->points;
    }

    public function render()
    {
        return view('livewire.leave-request.create');
    }
}
