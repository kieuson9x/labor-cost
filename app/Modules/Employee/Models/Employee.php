<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Department\Models\Department;

class Employee extends Model
{
    protected $guarded = [];

    public function department() {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public static function getEmployeeCode($prefix, $id) {
        return $prefix + $id;
    }
}
