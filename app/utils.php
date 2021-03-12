<?php

if (!function_exists('number_to_VND')) {

    function number_to_VND($value)
    {
        return number_format(round($value), 0, '', '.') . ' VND';
    }
}

if (!function_exists('VND_to_number')) {

    function VND_to_number($value)
    {
        return str_replace('.', '', str_replace('VND', '', $value));
    }
}
