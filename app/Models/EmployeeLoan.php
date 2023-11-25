<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'loan_id',
        'amount',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function loan(){
        return $this->belongsTo(Loan::class);
    }
}
