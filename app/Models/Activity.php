<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'ip_address',
        'updated_from',
        'updated_to',
    ];

    protected $casts = [
        'updated_from' => Json::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
