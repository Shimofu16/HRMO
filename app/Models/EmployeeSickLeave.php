<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSickLeave extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'sick_leave',
        'sick_leave_balance',
        'sick_leave_total',
        'sick_leave_used',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
