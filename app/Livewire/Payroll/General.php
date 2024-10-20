<?php

namespace App\Livewire\Payroll;

use Livewire\Component;

class General extends Component
{
    public $filename;
    public $dateTitle;
    public $payroll;
    public $from;
    public $to;
    public $department;
    public $loans;
    public $deductions;
    public $signatures;
    public $employees;

    public function mount($filename, $dateTitle, $payroll, $from, $to, $department, $loans, $deductions, $signatures, $employees)
    {
        // Assign values to the component properties from the passed parameters
        $this->filename = $filename;
        $this->dateTitle = $dateTitle;
        $this->payroll = $payroll;
        $this->from = $from;
        $this->to = $to;
        $this->department = $department;
        $this->loans = $loans;
        $this->deductions = $deductions;
        $this->signatures = $signatures;
        $this->employees = $employees;
    }

    public function render()
    {
        // Return the view with the necessary data for rendering
        return view('livewire.payroll.general', [
            'filename' => $this->filename,
            'dateTitle' => $this->dateTitle,
            'payroll' => $this->payroll,
            'from' => $this->from,
            'to' => $this->to,
            'department' => $this->department,
            'loans' => $this->loans,
            'deductions' => $this->deductions,
            'signatures' => $this->signatures,
            'employees' => $this->employees
        ]);
    }
}