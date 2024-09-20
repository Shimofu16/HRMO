<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAllowance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'allowance_id',
        'amount',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function allowance()
    {
        return $this->belongsTo(Allowance::class);
    }
    public function getAllowance($allowance_id, $range)
    {
        $allowance = $this->allowances()->where('allowance_id', $allowance_id)->first();
        if ($allowance) {
            foreach ($allowance->allowance->allowance_ranges as $key => $allowance_range) {
                if ($range == $allowance_range) {
                    if ($allowance->allowance->allowance_code == 'Hazard' || $allowance->allowance->allowance_code == 'Representation' || $allowance->allowance->allowance_code == 'Transportation') {
                        if ($allowance->allowance->allowance_code == 'Hazard') {
                            return getHazard($this->data->salary_grade_id, $this->data->monthly_salary);
                        }else{
                            dd(getHazard($this->data->salary_grade_id, $this->data->monthly_salary));
                            return $allowance->amount;
                        }
                    } else {
                        return $allowance->allowance->allowance_amount;
                    }
                }
            }
        }
        return 0;
    }
}
