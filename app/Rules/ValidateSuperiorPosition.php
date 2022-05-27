<?php

namespace App\Rules;

use App\Models\Employee;
use Illuminate\Contracts\Validation\ImplicitRule;

class ValidateSuperiorPosition implements ImplicitRule
{
    const AllOWED_POSITION_TYPES = ['management'];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $employee = Employee::find($value);

        if ($employee) {
            if (in_array(strtolower($employee->position->type), self::AllOWED_POSITION_TYPES)) {
                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Selected employee cannot be superior to other employees.';
    }
}
