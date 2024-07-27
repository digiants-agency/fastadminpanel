<?php

namespace App\FastAdminPanel\Requests\Crud;

use App\FastAdminPanel\Rules\ExistsOrZero;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
	protected function prepareForValidation()
	{
		$this->merge([
			'title'				=> $this->title ?? '',
			'fields'			=> $this->fields ?? [],
			'is_dev'			=> $this->is_dev ?? 0,
			'is_soft_delete'	=> $this->is_soft_delete ?? 0,
			'sort'				=> $this->sort ?? 10,
			'dropdown_slug'		=> $this->dropdown_slug ?? '',
			'icon'				=> $this->icon ?? '',
			'is_docs'			=> $this->is_docs ?? 1,
			'is_statistics'		=> $this->is_statistics ?? 0,
			'model'				=> $this->model ?? '',
			'default_order'		=> $this->default_order ?? '',
		]);
	}

	public function rules()
	{
		return [
			'title'				=> ['required'],
			'fields'			=> ['required', 'array'],	// TODO: add fields.* validation
			'is_dev'			=> ['required', 'integer', 'between:0,1'],
			'is_soft_delete'	=> ['required', 'integer', 'between:0,1'],
			'sort'				=> ['required', 'integer', 'between:-2000000,2000000'],
			'dropdown_slug'		=> ['nullable'], // TODO: add something like "new ExistsOrZero('dropdowns')"
			'icon'				=> ['nullable'],
			'is_docs'			=> ['required', 'integer', 'between:0,1'],
			'is_statistics'		=> ['required', 'integer', 'between:0,1'],
			'model'				=> ['nullable', 'max:191'],
			'default_order'		=> ['nullable', 'max:191'],
		];
	}
}
