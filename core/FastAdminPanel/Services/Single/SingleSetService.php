<?php

namespace App\FastAdminPanel\Services\Single;

use App\FastAdminPanel\Models\SingleField;

class SingleSetService
{
	protected $model;

	public function __construct(SingleField $model)
	{
		$this->model = $model;
	}

	public function set($blocks)
	{
		// TODO: reduce number of requests to DB
		foreach ($blocks as $block) {

			foreach ($block['fields'] as $field) {

				$singleField = $this->model->find($field['id']);

				if ($field['type'] != 'repeat') {

					$singleField->value = $singleField->encodeValue($field['value'] ?? null);

				} else {

					$this->repeat($field['value']['fields']);

					$singleField->value = $singleField->encodeValue($field['value']['length']);
				}

				$singleField->multilanguageSave();
			}			
		}
	}

	protected function repeat($fields)
	{
		foreach ($fields as $field) {

			$singleField = $this->model->find($field['id']);

			if ($field['type'] != 'repeat') {

				$func = function ($item) use (&$func, $singleField) {
					return is_array($item) ? array_map($func, $item) : $singleField->encodeValue($item);
				};

				$formatted = array_map($func, $field['value']);
				
				$singleField->value = json_encode($formatted, JSON_UNESCAPED_UNICODE);

			} else {

				$this->repeat($field['value']['fields']);

				$singleField->value = $singleField->encodeValue($field['value']['length']);
			}

			$singleField->multilanguageSave();
		}
	}
}