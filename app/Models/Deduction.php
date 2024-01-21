<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'deduction_code',
        'deduction_name',
        'deduction_amount',
        'deduction_amount_type',
        'deduction_type',
        'deduction_range',
        // Other fillable attributes
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'deduction');
    }
}
