<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSickLeave extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'points',
    ];

    public $cast = [
        'points' => 'double',   
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
