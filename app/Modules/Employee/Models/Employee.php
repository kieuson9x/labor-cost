<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public static function getEmployeeCode($prefix, $id) {
        return $prefix + $id;
    }
}
