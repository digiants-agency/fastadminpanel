<?php

namespace App\FastAdminPanel\Requests\Api;

use App\FastAdminPanel\Rules\FieldTypeRule;

class UpdateRequest extends ApiRequest
{
    public function rules(): array
    {
        $fieldsTypes = $this->crud->getFieldsType();
        $fieldsRequired = $this->crud->getFieldsRequired();

        $rules = [];

        foreach ($this->all() as $key => $field) {
            $rules[$key] = [$fieldsRequired[$key], new FieldTypeRule($fieldsTypes[$key], $fieldsRequired[$key])];
        }

        return $rules;
    }
}
