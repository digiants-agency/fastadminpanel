<?php

namespace App\FastAdminPanel\Requests\Api;

use App\FastAdminPanel\Helpers\Field;
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

		$fieldsTypes = $this->route()->parameters()['menu_item']->getFieldsType();

		$default = [];

		foreach ($fieldsTypes as $key => $field) {
			$default[$key] = Field::default($field);
		}

		foreach ($data as $dataField => $value) {
			$default[$dataField] = $value;
		}

		return $default;
	}

    public function rules() : array
	{
		$fieldsTypes = $this->route()->parameters()['menu_item']->getFieldsType();
		$fieldsRequired = $this->route()->parameters()['menu_item']->getFieldsRequired();

		foreach ($fieldsTypes as $key => $field) {
			$rules[$key] = [$fieldsRequired[$key], new FieldTypeRule($field, $fieldsRequired[$key])];
		}

		return $rules;
    }
}
