<?php 

namespace App\FastAdminPanel\Services;

use App\FastAdminPanel\Generators\Models\ModelGenerator;

class ModelService
{
	protected $generator;

	public function __construct(ModelGenerator $generator)
	{
		$this->generator = $generator;
	}

	public function create($data)
	{
		return $this->generator->create(
			$data['table_name'], 
			$data['multilanguage'], 
			json_decode($data['fields'])
		);
	}

	public function update($data)
	{
		return $this->generator->update(
			$data['table_name'], 
			$data['multilanguage'], 
			json_decode($data['fields'])
		);
	}

	public function delete($data)
	{
		return $this->generator->delete(
			$data['table_name'], 
		);
	}
}