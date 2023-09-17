<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSickLeaveRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'sick_leave_date',
        'sick_leave_reason',
        'sick_leave_status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
