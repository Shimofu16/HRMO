<?php

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
