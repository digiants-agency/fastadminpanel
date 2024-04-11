<?php

namespace App\FastAdminPanel\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllOrArrayRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (is_string($value) && $value == '*') || is_array($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be * or array';
    }
}
