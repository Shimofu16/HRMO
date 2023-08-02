<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sgrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'sg_code',
        'sg_name',
        'sg_amount',
        // Other fillable attributes
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'sgrade_id');
    }

    public function payroll()
    {
        return $this->hasMany(Payroll::class, 'pr_sgrade');
    }
}
