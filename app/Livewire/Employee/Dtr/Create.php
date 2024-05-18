<?php

namespace App\Livewire\Employee\Dtr;

use App\Models\Attendance;
use Livewire\Component;

class Create extends Component
{
    public $employee;
    public $months;
    public $selected_month;
    public $days;
    public $selected_days;

    public $present = 0;
    public $absent  = 0;
    public $late = 0;
    public $halfday = 0;
    public $under_time = 0;
    public $total_man_hour = 0;
    public $attendances;

    public bool $debugMode = false;

    public function updatedSelectedDays($value)
    {
        if ($value && $this->selected_month) {
            $dates = explode('-', $value);
            $from = $dates[0];
            $to = $dates[1];
            $data = attendanceCount($this->employee, $this->selected_month, now()->format('Y'), $from, $to);
            // dd($data);
            $this->present = $data['present'];
            $this->absent = $data['absent'];
            $this->late = $data['late'];
            $this->halfday = $data['halfday'];
            $this->under_time = $data['under_time'];
            $this->total_man_hour = $data['total_man_hour'];
            $this->attendances = $data['attendances'];
        }
    }
    public function updatedSelectedMonth($value)
    {
        if ($value && $this->selected_days) {
            $dates = explode('-', $this->selected_days);
            $from = $dates[0];
            $to = $dates[1];


            $data = attendanceCount($this->employee, $this->selected_month, now()->format('Y'), $from, $to);
            $this->present = $data['present'];
            $this->absent = $data['absent'];
            $this->late = $data['late'];
            $this->halfday = $data['halfday'];
            $this->under_time = $data['under_time'];
            $this->total_man_hour = $data['total_man_hour'];
            $this->attendances = $data['attendances'];
        }
    }

    public function mount()
    {
        $this->months = Attendance::selectRaw('MONTH(time_in) as month, MIN(time_in) as earliest_time_in')
            ->where('isPresent', 1)
            ->where('employee_id', $this->employee->id)
            ->whereYear('time_in', now()->format('Y'))
            ->groupByRaw('MONTH(time_in)')
            ->orderByRaw('MONTH(time_in)')
            ->get();
        $this->days = collect(['1-15', '16-30']);
        $this->attendances = collect();
        // dd($this->months, $this->days);
    }
    public function render()
    {
        $this->months = Attendance::selectRaw('MONTH(time_in) as month, MIN(time_in) as earliest_time_in')
            ->where('isPresent', 1)
            ->where('employee_id', $this->employee->id)
            ->whereYear('time_in', now()->format('Y'))
            ->groupByRaw('MONTH(time_in)')
            ->orderByRaw('MONTH(time_in)')
            ->get();
        return view('livewire.employee.dtr.create');
    }
}
