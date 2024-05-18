<?php

namespace App\Livewire\LeaveRequest;

use App\Models\Employee;
use App\Models\EmployeeLeaveRequest;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{
    public array $types;
    public int $employee_id;
    public  $employees;
    public  $employee;
    public  $start;
    public  $end;
    public $type;
    public float $points = 0;
    public float $points_per_day = 1.25;
    public int $days = 0;
    public int $days_leave = 0;

    public function updatedEmployeeId($value)
    {
        $this->employee = Employee::find($value);
        $this->points = ($this->employee->data->sick_leave_points) ? $this->employee->data->sick_leave_points : 0;

        // calculate the total days based on points
        $this->days =  $this->points /  $this->points_per_day;
    }
    public function updatedEnd($value)
    {
        if ($value) {
            $start = Carbon::parse($this->start);
            $end = Carbon::parse($this->end);
            //count the days between start and end
            $this->days_leave = getDatesBetween($start, $end, false);
            if ($this->days_leave >= $this->days && $this->days_leave != $this->days) {
                return session()->flash('error', 'The number of days exceeds the allowed limit.');
            }
        }
    }

    public  function save()
    {
        EmployeeLeaveRequest::create([
            'employee_id' => $this->employee_id,
            'start' => $this->start,
            'end' => $this->end,
            'type' => $this->type,
            'status' => 'accepted',
            'days' => $this->days_leave,
        ]);
        // Create activity
        createActivity('Create Employee Leave Request', 'Create Employee Leave Request for ' . $this->employee->full_name . '.', request()->getClientIp(true));

        // Redirect to the index page with a success message
        return redirect()->route('leave-requests.index', ['status' => 'accepted'])->with('success', 'Leave Request created successfully.');
    }

    public function mount()
    {
        $this->employees = Employee::all();
        $this->types = [
            'maternity_leave', 'vacation_leave', 'sick_leave', 'force_leave'
        ];
    }

    public function render()
    {
        return view('livewire.leave-request.create');
    }
}
