<?php

namespace App\FastAdminPanel\Requests\Crud;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
	protected function prepareForValidation()
	{
		$this->merge([
			'table_name'		=> $this->table_name ?? '',
			'title'				=> $this->title ?? '',
			'fields'			=> $this->fields ?? [],
			'is_dev'			=> $this->is_dev ?? 0,
			'multilanguage'		=> $this->multilanguage ?? 1,
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
			'table_name'		=> ['required'], // TODO: add something like 'unique:cruds,table_name'
			'title'				=> ['required'],
			'fields'			=> ['required', 'array'], // TODO: add fields.* validation
			'is_dev'			=> ['required', 'integer', 'between:0,1'],
			'multilanguage'		=> ['required', 'integer', 'between:0,1'],
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
