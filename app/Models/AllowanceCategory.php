<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowanceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'allowance_id',
        'category_id',
        'department_id',
        'type',
        'amount',
    ];

    public function allowance()
    {
        return $this->belongsTo(Allowance::class, 'allowance_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
