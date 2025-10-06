<?php

namespace App\FastAdminPanel\Requests\Single;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'icon' => strval($this->icon),
            'dropdown_slug' => strval($this->dropdown_slug),
        ]);
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'sort' => ['required', 'integer'],
            'icon' => ['string', 'nullable'],
            'dropdown_slug' => ['string', 'nullable'],
            'blocks' => ['required', 'array'],
        ];
    }
}
