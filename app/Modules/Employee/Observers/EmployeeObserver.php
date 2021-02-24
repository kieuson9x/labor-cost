<?php

namespace App\Modules\Employee\Observers;

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

        if (empty($employee->employee_code)) {
            $employee->update([
                'employee_code' => $formattedCode
            ]);
        }
    }
}
