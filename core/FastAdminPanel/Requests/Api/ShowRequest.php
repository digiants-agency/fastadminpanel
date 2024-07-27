<?php

namespace App\FastAdminPanel\Requests\Api;

use App\FastAdminPanel\Rules\AllOrArrayRule;
use App\FastAdminPanel\Rules\FieldsRule;
use App\FastAdminPanel\Rules\RelationsRule;

class ShowRequest extends ApiRequest
{
	/**
	 * Set default values
	 * 
	 * @return array
	 */
	public function validationData()
	{
		$data = $this->all();

		$data['fields']	= $data['fields'] ?? $this->crud->getFields();
		$data['relations'] = $data['relations'] ?? [];

		return $data;
	}

	public function rules() : array
	{
		return [
			'fields'	    => ['array'],
			'fields.*'	    => [new FieldsRule($this->crud)],
			'relations'	    => [new AllOrArrayRule()],
			'relations.*'	=> [new RelationsRule($this->crud)],
		];
	}
}
