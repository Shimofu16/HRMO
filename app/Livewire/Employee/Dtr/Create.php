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
    public $totalUnderTimeHours= 0;
    public $totalUnderTimeMinutes = 0;
    public bool $isMonthly = false;
    public $attendances;
    public string $dtr_type;
    public bool $debugMode = false;

    public function updatedSelectedDays($value)
    {
        if ($value && $this->selected_month) {
            $dates = explode('-', $value);
            $from = $dates[0];
            $to = $dates[1];
            $data = attendanceCount($this->employee, $this->selected_month, now()->format('Y'), $from, $to, $this->isMonthly);
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
        if (($value && $this->selected_days) || $this->isMonthly) {
            if ($this->isMonthly) {
                $dates = explode('-', '1-31');
            } else {
                $dates = explode('-', $this->selected_days);
            }
            $from = $dates[0];
            $to = $dates[1];
            


            $data = attendanceCount($this->employee, $this->selected_month, now()->format('Y'), $from, $to, $this->isMonthly);
            $this->present = $data['present'];
            $this->absent = $data['absent'];
            $this->late = $data['late'];
            $this->halfday = $data['halfday'];
            $this->under_time = $data['under_time'];
            $this->total_man_hour = $data['total_man_hour'];
            $this->totalUnderTimeHours = $data['totalUnderTimeHours'];
            $this->totalUnderTimeMinutes = $data['totalUnderTimeMinutes'];
            $this->attendances = $data['attendances'];
        }
    }

    public function updatedDtrType($value)
    {
        $this->isMonthly = ($value == 'monthly');
        $this->present = 0;
        $this->absent = 0;
        $this->late = 0;
        $this->halfday = 0;
        $this->under_time = 0;
        $this->total_man_hour = 0;
        $this->attendances = collect();
    
        if ($this->selected_month) {
            if ($this->isMonthly) {
                // Set date range for the entire month
                $from = 1;
                $to = date('t', strtotime($this->selected_month));
            } else if ($this->selected_days) {
                // Set date range based on selected days
                $dates = explode('-', $this->selected_days);
                $from = $dates[0];
                $to = $dates[1];
            } else {
                // No specific date range selected
                return;
            }
    
            // Fetch attendance data
            $data = attendanceCount($this->employee, $this->selected_month, now()->format('Y'), $from, $to, $this->isMonthly);
            $this->present = $data['present'];
            $this->absent = $data['absent'];
            $this->late = $data['late'];
            $this->halfday = $data['halfday'];
            $this->under_time = $data['under_time'];
            $this->total_man_hour = $data['total_man_hour'];
            $this->totalUnderTimeHours = $data['totalUnderTimeHours'] ?? 0;
            $this->totalUnderTimeMinutes = $data['totalUnderTimeMinutes'] ?? 0;
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
