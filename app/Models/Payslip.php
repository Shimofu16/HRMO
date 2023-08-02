<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;

    protected $fillable = [
        'ps_empno',
        'ps_empid',
        'total_allowance',
        'total_deduction',
        'grosspay',
        'netpay',
        // Other fillable attributes
    ];

    public function payroll()
    {
        return $this->hasMany(Payroll::class, 'payslip');
    }

}
