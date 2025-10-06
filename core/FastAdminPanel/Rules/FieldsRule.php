<?php

namespace App\FastAdminPanel\Rules;

use App\FastAdminPanel\Models\Crud;
use Illuminate\Contracts\Validation\Rule;

class FieldsRule implements Rule
{
    protected $fields;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Crud $crud)
    {
        $this->fields = $crud->getFields();
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
        return in_array($value, $this->fields);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be in '.implode(', ', $this->fields);
    }
}
