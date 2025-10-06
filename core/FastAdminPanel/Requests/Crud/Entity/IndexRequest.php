<?php

namespace App\FastAdminPanel\Requests\Crud\Entity;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'search' => $this->search ?? '',
            'per_page' => $this->per_page ?? 10,
            'sort_order' => $this->sort_order ?? 'DESC',
            'offset' => $this->offset ?? 0,
        ]);
    }

    public function rules()
    {
        return [
            'search' => ['max:191'],
            'per_page' => ['integer', 'between:10,200'],
            'order' => ['required'],	// TODO: validation by field
            'sort_order' => ['in:ASC,DESC'],
            'offset' => ['integer', 'between:0,2000000000'],
        ];
    }
}
