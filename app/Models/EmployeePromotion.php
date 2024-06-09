<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePromotion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function old()
    {
        return $this->belongsTo(Category::class, 'old_category_id');
    }
    public function new()
    {
        return $this->belongsTo(Category::class, 'new_category_id');
    }
}
