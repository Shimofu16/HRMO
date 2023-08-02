<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    protected $fillable = [
        'allowance_code',
        'allowance_name',
        'allowance_amount',
        // Other fillable attributes
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class,'allowance');
    }
}
