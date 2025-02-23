<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hazard extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'department_id',
        'name',
        'amount',
        'amount_type',
        'ranges',
    ];

    protected $casts = [
        'ranges' => Json::class,
    ];

    public function salaryGrades()
    {
        return $this->hasMany(HazardSalaryGrade::class, 'hazard_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    
}
