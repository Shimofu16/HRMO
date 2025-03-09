<?php

namespace App\Models;

use App\Casts\Json;
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
        'start_date',
        'end_date',
        'duration',
        'period',
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
        return $this->amount / 15;
    }
}
