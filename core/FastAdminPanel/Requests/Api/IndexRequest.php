<?php

namespace App\FastAdminPanel\Requests\Api;

use App\FastAdminPanel\Rules\AllOrArrayRule;
use App\FastAdminPanel\Rules\FieldsRule;
use App\FastAdminPanel\Rules\RelationsRule;

class IndexRequest extends ApiRequest
{
    /**
     * Set default values
     *
     * @return array
     */
    public function validationData()
    {
        $data = $this->all();

        $data['perPage'] = $data['perPage'] ?? 15;
        $data['sort'] = $data['sort'] ?? 'id';
        $data['order'] = $data['order'] ?? 'asc';
        $data['search'] = $data['search'] ?? '';
        $data['fields'] = $data['fields'] ?? $this->crud->getFields();
        $data['relations'] = $data['relations'] ?? [];
        $data['filters'] = $data['filters'] ?? [];

        return $data;
    }

    public function rules(): array
    {
        return [
            'sort' => [new FieldsRule($this->crud)],
            'order' => ['in:desc,asc'],
            'search' => ['max:191'],
            'perPage' => ['integer', 'between:0,10000'],
            'fields' => ['array'],
            'fields.*' => [new FieldsRule($this->crud)],
            'relations' => [new AllOrArrayRule],
            'relations.*' => [new RelationsRule($this->crud)],
            'filters' => ['array'],
            // 'filters.*'	    => [new FieldsRule()],
        ];
    }
}
