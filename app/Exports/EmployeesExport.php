<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employee::all();
    }
    public function map($employee): array
    {
        return [
            $employee->employee_number,
            $employee->ordinance_number,
            $employee->full_name,
            $employee->data->department->dep_code,
            $employee->data->designation->designation_code,
            $employee->data->category->category_code
        ];
    }
    public function headings(): array
    {
        return [
            'ID #',
            'Ordinance Item #',
            'Name',
            'Department',
            'Position Title',
            'Type of Employment',
        ];
    }
}
