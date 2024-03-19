<?php

use App\Models\SalaryGrade;
use Illuminate\Support\Str;



if (!function_exists('createActivity')) {
    function createActivity($type, $message, $ip_address = null, $model = null, $request = null)
    {
        try {
            $updated_from = null;
            $updated_to = null;

            if ($model) {
                // get the only updated fields
                $updated_from = $model->getOriginal();
                $updated_to = $request->all();
                // to json
                $updated_from = json_encode($updated_from);
                $updated_to = json_encode($updated_to);
            }

            auth()->user()->activities()->create([
                'type' => $type,
                'message' => $message,
                'ip_address' => $ip_address,
                'updated_from' => $updated_from,
                'updated_to' => $updated_to,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

if (!function_exists('toCode')) {
    function toCode($text)
    {
        $words = preg_split("/[\s,]+/", $text);
        $code = "";
        $excludedWords = ["of", "the", "is", "it", "and"]; // Add any words you want to exclude here

        foreach ($words as $w) {
            if (!in_array(strtolower($w), $excludedWords)) {
                $code .= Str::upper($w[0]);
            }
        }

        return $code;
    }
}
if (!function_exists('percentage')) {
    function percentage($number)
    {
        return $number . '%';
    }
}
if (!function_exists('money')) {
    function money($number, $currency = 'PHP')
    {
        $currency = Str::upper($currency);
        return $currency . ' ' . $number;
    }
}
if (!function_exists('computePercentage')) {
    function computePercentage($number)
    {
        return $number . '%';
    }
}
if (!function_exists('getLoan')) {
    function getLoan($loan, $duration)
    {
        return $loan / ($duration * 2);
    }
}

if (!function_exists('getSalaryGradesTotalSteps')) {

    function getSalaryGradesTotalSteps()
    {
        $total_steps = 0;
        $temp = 0;
        foreach (SalaryGrade::all() as $key => $salary_grade) {
            $temp =  count($salary_grade->steps);
            if ($temp > $total_steps) {
                $total_steps = $temp;
            }
            $temp =  $total_steps;
        }

        return $total_steps;
    }
}

if (!function_exists('getSalaryStepAmount')) {

    function getSalaryStepAmount($salary_grade_steps, $step)
    {
        foreach ($salary_grade_steps as $key => $salary_grade_step) {
            if (Str::lower($salary_grade_step['step']) == Str::lower($step)) {
                return $salary_grade_step['amount'];
            }
        }
        return 0;
    }
}
