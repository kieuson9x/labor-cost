<?php

namespace App\Modules\Employee\Observer;

use App\Modules\Employee\Models\Employee;

class EmployeeObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(Employee $employee)
    {
        $formattedCode = sprintf('KR%05d', $employee->id);

        $employee->update([
            'employee_code' => $formattedCode
        ]);
    }


}