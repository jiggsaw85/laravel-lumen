<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;

class ValidatePositionType implements ImplicitRule
{
    const ALLOWED_TYPES = ['regular', 'management'];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (in_array(strtolower($value), self::ALLOWED_TYPES)) {
            return true;
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
        return 'The type you added is not allowed.';
    }
}
