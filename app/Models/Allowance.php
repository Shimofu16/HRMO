<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    protected $fillable = [
        'allowance_code',
        'allowance_name',
        'allowance_amount',
        'allowance_ranges',
        // Other fillable attributes
    ];

   /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'allowance_ranges' => Json::class,
    ];

    public function employees()
    {
        return $this->hasMany(EmployeeAllowance::class, 'allowance_id');
    }

    public function categories()
    {
        return $this->hasMany(AllowanceCategory::class, 'allowance_id');
    }
}
