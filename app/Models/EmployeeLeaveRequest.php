<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'start',
        'end',
        'type',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
