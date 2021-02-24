<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Employee\Models\Overtime;
use App\Modules\Department\Models\Department;

class Employee extends Model
{
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'employee_id', 'id');
    }

    public function overtimes()
    {
        return $this->hasMany(Overtime::class, 'employee_id', 'id');
    }

    public static function getEmployeeCode($prefix, $id)
    {
        return $prefix + $id;
    }
}
