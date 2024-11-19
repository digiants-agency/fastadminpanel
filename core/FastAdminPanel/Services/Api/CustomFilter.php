<?php

namespace App\FastAdminPanel\Services\Api;

class CustomFilter
{
	public function filter($entity, $method, $crud)
	{
		$filterClass = "\App\FastAdminPanel\Api\Filter\\{$method}{$crud->table_name}Filter";

		if (!class_exists($filterClass)) {

			return;
		}

		$filter = app()->make($filterClass);

		$filter->change($entity, $crud);
	}
}