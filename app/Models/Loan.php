<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount',
    ];

    public function employee_loans()
    {
        return $this->hasMany(EmployeeLoan::class);
    }
}
