<?php

namespace App\FastAdminPanel\Services\Single;

use App\FastAdminPanel\Services\Service;
use App\FastAdminPanel\Models\SingleField;

class SingleSetService extends Service
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

			foreach ($block as $block_field) {

				$field = $this->model->find($block_field['id']);

				if ($block_field['type'] != 'repeat') {

					$field->value = $field->encodeValue($block_field['value'] ?? null);

				} else {

					$this->repeat($block_field['value']['fields']);

					$field->value = $field->encodeValue($block_field['value']['length']);
				}

				$field->multilanguageSave();
			}			
		}
	}

	protected function repeat($block_fields)
	{
		foreach ($block_fields as $block_field) {

			$field = $this->model->find($block_field['id']);

			if ($block_field['type'] != 'repeat') {

				$func = function ($item) use (&$func, $field) {
					return is_array($item) ? array_map($func, $item) : $field->encodeValue($item);
				};

				$formatted = array_map($func, $block_field['value']);
				
				$field->value = json_encode($formatted);

			} else {

				$this->repeat($block_field['value']['fields']);

				$field->value = $field->encodeValue($block_field['value']['length']);
			}

			$field->multilanguageSave();
		}
	}
}