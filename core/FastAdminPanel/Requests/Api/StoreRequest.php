<?php

namespace App\FastAdminPanel\Requests\Api;

use App\FastAdminPanel\Rules\FieldTypeRule;

class StoreRequest extends ApiRequest
{
    /**
     * Set default values
     *
     * @return array
     */
    public function validationData()
    {
        $data = $this->all();

        $default = [];

        // $this->crud->fields->filter(fn ($field) => $field->getDbTitle())
        // ->each(fn ($field) => $default[$field->getDbTitle()] = $field->default());

        foreach ($this->crud->fields as $field) {

            $dbTitle = $field->getDbTitle();

            if ($dbTitle) {
                $default[$dbTitle] = $field->default();
            }
        }

        foreach ($data as $dataField => $value) {
            $default[$dataField] = $value;
        }

        return $default;
    }

    public function rules(): array
    {
        $fieldsTypes = $this->crud->getFieldsType();
        $fieldsRequired = $this->crud->getFieldsRequired();

        foreach ($fieldsTypes as $key => $field) {
            $rules[$key] = [$fieldsRequired[$key], new FieldTypeRule($field, $fieldsRequired[$key])];
        }

        return $rules;
    }
}
