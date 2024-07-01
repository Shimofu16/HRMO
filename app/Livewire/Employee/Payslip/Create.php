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
            $this->payrolls = $this->getPayroll();
        }
        // $this->year = null;
    }
    public function updatedMonth($value)
    {
        if ($value) {
            // dd($value);
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
        $months = Attendance::query()->selectRaw('MONTH(time_in) as month, MIN(time_in) as earliest_time_in')
            ->where('employee_id', $this->employee->id)
            ->where('isPresent', 1)
            ->groupByRaw('MONTH(time_in)')
            ->orderByRaw('MONTH(time_in)');
            if ($this->month) {
                $months->whereMonth('time_in', date('m', strtotime($this->month)));
            }
            if ($this->year) {
                $months->whereYear('time_in', date('Y', strtotime($this->year)));
            }
        $fromTo = ['1-15', '16-31'];
        foreach ($months->get() as $month) {
                foreach ($fromTo as $itemDay) {
                    // Create a unique key for the payroll record
                    $uniqueKey = "{$month->month}_{$itemDay}";

                    // Only create a new payroll record if it doesn't exist
                    if (!isset($payrolls[$uniqueKey])) {
                        $payrolls[$uniqueKey] = [
                            'key' => $uniqueKey,
                            'month' => date('F', strtotime($month->earliest_time_in)),
                            'year' => date('Y', strtotime($month->earliest_time_in)),
                            'date_from_to' => $itemDay,
                            'date' => $month->earliest_time_in,
                        ];
                    }
                }
        }
        return $payrolls;
    }
    public function mount()
    {
        $months = Attendance::selectRaw('MONTH(time_in) as month, MIN(time_in) as earliest_time_in')
            ->where('employee_id', $this->employee->id)
            ->where('isPresent', 1)
            ->groupByRaw('MONTH(time_in)')
            ->orderByRaw('MONTH(time_in)')
            ->get();

        $this->payrolls = collect();
        $this->years = $this->getYears($months);
        $this->months = $this->getMonths($months);
        // dd($this->years, $this->months);
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