<?php

namespace App\FastAdminPanel\Requests\Dropdown;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
	{
		return [
			'dropdowns'			=> ['required', 'array'],
			'dropdowns.*.slug'	=> ['max:191'],
			'dropdowns.*.title'	=> ['max:191'],
			'dropdowns.*.sort'	=> ['integer', 'between:-1000000,1000000'],
			'dropdowns.*.icon'	=> ['max:191'],
		];
    }
}
