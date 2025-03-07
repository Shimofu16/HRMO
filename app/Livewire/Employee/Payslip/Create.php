<?php

namespace App\Livewire\Employee\Payslip;

use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\Deduction;
use App\Models\Loan;
use Livewire\Component;

class Create extends Component
{
    public $employee;
    public $payrolls;
    public $allowances;
    public $deductions;
    public $loans;
    public $month;
    public $months;
    public $year;
    public $years;
    public $file_name;

    public function updatedYear($value)
    {
        if ($value) {
            // dd($value);
            $this->month = null;
            $this->year = $value;
            $this->payrolls = $this->getPayroll();
            // dd($this->payrolls, $this->year, $this->months);
        }
        // $this->year = null;
    }
    public function updatedMonth($value)
    {
        if ($value) {
            $this->month = $value;
            $this->payrolls = $this->getPayroll();
        }
        // $this->month = null;
    }

    private function getYears($months)
    {
        $years = [];

        foreach ($months as $month) {
            $uniqueKey = date('Y', strtotime($month->earliest_time_in));
            // Only create a new payroll record if it doesn't exist
            if (!isset($years[$uniqueKey])) {
                $years[$uniqueKey] = date('Y', strtotime($month->earliest_time_in));
            }
        }
        return $years;
    }
    private function getMonths($months)
    {
        $formatted = [];

        foreach ($months as $month) {
            $uniqueKey = date('F', strtotime($month->earliest_time_in));
            // Only create a new payroll record if it doesn't exist
            if (!isset($formatted[$uniqueKey])) {
                $formatted[$uniqueKey] = date('F', strtotime($month->earliest_time_in));
            }
        }
        return $formatted;
    }
    private function getPayroll()
    {
        $payrolls = [];
        $attendances = Attendance::query()
        ->selectRaw('YEAR(time_in) as year, MONTH(time_in) as month, MIN(time_in) as earliest_time_in')
        ->where('employee_id', $this->employee->id)
        ->where('isPresent', 1)
        ->groupByRaw('YEAR(time_in), MONTH(time_in)')
        ->orderByRaw('YEAR(time_in), MONTH(time_in)');
        
        if (!empty($this->year)) {
            $attendances->whereYear('time_in', $this->year);
        }
        $this->months = $this->getMonths($attendances->get());
        if (!empty($this->month)) {
            $attendances->whereMonth('time_in', date('n', strtotime($this->month)));
        }

        
        // dd($attendances);

        $fromTo = ['1-15', '16-31'];
        foreach ($attendances->get() as $attendance) {
                foreach ($fromTo as $itemDay) {
                    // Create a unique key for the payroll record
                    $uniqueKey = "{$attendance->month}_{$itemDay}";

                    // Only create a new payroll record if it doesn't exist
                    if (!isset($payrolls[$uniqueKey])) {
                        $payrolls[$uniqueKey] = [
                            'key' => $uniqueKey,
                            'month' => date('F', strtotime($attendance->earliest_time_in)),
                            'year' => date('Y', strtotime($attendance->earliest_time_in)),
                            'date_from_to' => $itemDay,
                            'date' => $attendance->earliest_time_in,
                        ];
                    }
                }
        }

        return $payrolls;
    }
    public function mount()
    {
        $attendances = Attendance::query()
        ->selectRaw('YEAR(time_in) as year, MONTH(time_in) as month, MIN(time_in) as earliest_time_in')
        ->where('employee_id', $this->employee->id)
        ->where('isPresent', 1)
        ->groupByRaw('YEAR(time_in), MONTH(time_in)')
        ->orderByRaw('YEAR(time_in), MONTH(time_in)')
            ->get();
            // dd($attendances);

        $this->payrolls = collect();
        $this->years = $this->getYears($attendances);
        $this->months = collect();
        // dd($this->years, $this->months, $attendances);
        $this->allowances = Allowance::all();
        $this->deductions = Deduction::all();
        $this->loans = Loan::all();
        // $this->file_name = "{$this->employee->full_name} - Payslip";
    }
    public function render()
    {
        return view('livewire.employee.payslip.create');
    }
}