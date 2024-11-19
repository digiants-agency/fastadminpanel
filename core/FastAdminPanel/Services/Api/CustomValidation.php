<?php

namespace App\FastAdminPanel\Services\Api;

class CustomValidation
{
	public function validate($method, $crud, $isRequired = false)
	{
		$validatorClass = "\App\FastAdminPanel\Api\Validation\\{$method}{$crud->table_name}Validation";

		if (!class_exists($validatorClass)) {

			if ($isRequired) {
				abort(501, "Method has to be validated. Please create a validator class: \App\FastAdminPanel\Api\Validation\\" . ucfirst($method) . ucfirst($crud->table_name) . "Validation.php. You can check the example in the folder.");
			}

			return;
		}

		$validator = app()->make($validatorClass);

		$validator->validate();
	}
}