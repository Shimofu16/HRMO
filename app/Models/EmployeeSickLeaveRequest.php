<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSickLeaveRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'date',
        'type',
        'reason',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
