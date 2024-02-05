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
        'deduction',
        'duration',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function amountToPay()
    {
        return $this->amount / ($this->duration * 2);
    }
}
