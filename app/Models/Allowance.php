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
        'allowance_range',
        'category_id',
        // Other fillable attributes
    ];

    public function employees()
    {
        return $this->hasMany(EmployeeAllowance::class,'allowance_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
