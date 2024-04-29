<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFingerprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'fullname',
        'indexfinger',
        'middlefinger',
    ];
}
