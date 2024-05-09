<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FingerClock extends Model
{
    use HasFactory;
    protected $table = 'fingerclock';
    protected $appends = ['employee_number', 'date', 'time'];

    public function getEmployeeNumberAttribute()
    {
        return $this->namee;
    }
    public function getDateAttribute()
    {
        // Assuming $this->Datee contains the input date string ("Wednesday, May 08, 2024")
        $carbonDate = Carbon::createFromFormat('l, F d, Y', $this->Datee);
        return $carbonDate->format('Y-m-d');
    }

    public function getTimeAttribute()
    {
        $carbonTime = Carbon::createFromFormat('h:i:s a', $this->timee);
        return  $carbonTime->format('H:i:s');
    }
}
