<?php

namespace App\Livewire\Payroll;

use App\Models\Employee;
use Illuminate\Support\Str;
use Livewire\Component;

class General extends Component
{
    // Public properties for the component
    public ?string $payment_method = null;  // Nullable string, to handle uninitialized values
    public ?string $employment_type = null; // Nullable string
    public array $selected_signatures = [];     // Nullable string for signature

    // Other properties needed for the component
    public $filename;
    public $dateTitle;
    public $payroll;
    public $from;
    public $to;
    public $department;
    public $loans;
    public $deductions;
    public $signatures;
    public $dbemployees;
    public  bool $isEmpty = false;

    // Render the component view with the necessary data
    public function render()
    {
        $employees  =$this->dbemployees;
        $this->isEmpty = false;
        if ($this->employment_type && $this->payment_method) {
            // Filter the employees collection in memory using the filter method
            $employees = $employees->filter(function ($employee) {
                return Str::upper($employee->data->category->category_code) === Str::upper($this->employment_type) && Str::upper($employee->data->payroll_type)=== Str::upper($this->payment_method);
            });
            if (count($employees) == 0) {
                $this->isEmpty = true;
            }
            // dd($employees,count($employees), $this->isEmpty);
        }
        // Ensure the view has all the variables it needs
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
            'payment_method' => $this->payment_method,
            'employment_type' => $this->employment_type,
            'selected_signatures' => $this->selected_signatures,
            'employees' => $employees,
        ]);
    }
}