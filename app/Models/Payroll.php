<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pr_department',
        'month',
        'year',
        'date_from_to',

    ];

    /**
     * Get the category associated with the employee.
     */
    public function pr_department()
    {
        return $this->belongsTo(Deduction::class, 'pr_department_id');
    }

    public function payslip()
    {
        return $this->belongsTo(Payslip::class, 'payslip_id');
    }
}
