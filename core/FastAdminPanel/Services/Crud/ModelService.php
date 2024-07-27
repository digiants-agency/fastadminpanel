<?php 

namespace App\FastAdminPanel\Services\Crud;

use App\FastAdminPanel\Casts\Fields;
use App\FastAdminPanel\Generators\Models\ModelGenerator;

class ModelService
{
	public function __construct(
		protected ModelGenerator $generator,
		protected Fields $fieldsCast,
	) { }

	public function create($crud)
	{
		return $this->generator->create(
			$crud->table_name,
			$crud->multilanguage,
			$crud->fields
		);
	}

	public function update($crud)
	{
		return $this->generator->update(
			$crud->table_name,
			$crud->model,
			$crud->multilanguage,
			$crud->fields
		);
	}

	public function delete($crud)
	{
		return $this->generator->delete(
			$crud->model,
		);
	}
}