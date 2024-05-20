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
    public $year;
    public $years;
    public $file_name;

    public function updatedYear($value){
        if ($value) {
            // dd($value);
            $months = Attendance::selectRaw('MONTH(time_in) as month, MIN(time_in) as earliest_time_in')
                ->where('employee_id', $this->employee->id)
                ->where('isPresent', 1)
                ->whereYear('time_in', now()->format('Y'))
                ->groupByRaw('MONTH(time_in)')
                ->orderByRaw('MONTH(time_in)')
                ->get();
            $this->payrolls = $this->getPayroll($months);
        }
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
    private function getPayroll($months)
    {
        $payrolls = [];
        $fromTo = ['1-15', '16-31'];
        foreach ($months as $month) {
                if ($this->year == date('Y', strtotime($month->earliest_time_in))) {
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
                            ];
                        }
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
            ->whereYear('time_in', now()->format('Y'))
            ->groupByRaw('MONTH(time_in)')
            ->orderByRaw('MONTH(time_in)')
            ->get();
        $this->payrolls = $this->getPayroll($months);
        $this->years = $this->getYears($months);
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
