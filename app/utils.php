<?php

if (!function_exists('number_to_VND')) {

    function number_to_VND($value)
    {
        if ((int)($value) >= 1000) {
            $pattern = '/\B(?=(\d{3})+(?!\d))/';
            return preg_replace($pattern, '.', strval($value)) . "VND";
        } else {
            return $value . "VND";
        }
    }
}

if (!function_exists('VND_to_number')) {

    function VND_to_number($value)
    {
        return str_replace('.', '', str_replace('VND', '', $value));
    }
}
