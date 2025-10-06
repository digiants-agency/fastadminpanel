<?php

namespace App\FastAdminPanel\Rules;

use App\FastAdminPanel\Models\Crud;
use Illuminate\Contracts\Validation\Rule;

class RelationsRule implements Rule
{
    protected $relations;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Crud $crud)
    {
        $this->relations = $crud->getRelations();
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
        return in_array($value, $this->relations);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be in '.implode(', ', $this->relations);
    }
}
