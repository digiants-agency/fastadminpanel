<?php

namespace App\FastAdminPanel\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
	{
		return [
			'tag' => ['required', 'min:2', 'max:2', 'unique:languages,tag'],
		];
    }
}
