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
        'ranges',
    ];

    protected $casts = [
        'ranges' => Json::class,
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
