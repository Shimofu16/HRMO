<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rata extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'amount',
        'ranges',
    ];

    protected $casts = [
        'ranges' => Json::class
    ];
}
