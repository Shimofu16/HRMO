<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'dep_code',
        'dep_name',
        // Other fillable attributes
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

}
