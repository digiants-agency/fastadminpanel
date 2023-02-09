<?php

namespace App\FastAdminPanel\Single\Api;

class Setter {

	protected $page_id;
	protected $model;

	public function __construct($model, $page_id) {

		$this->model = $model;
		$this->page_id = $page_id;
	}

	public function set($blocks) {

		// TODO: reduce number of requests to DB
		foreach ($blocks as $block) {

			foreach ($block as $block_field) {

				$field = $this->model->where('id', $block_field['id'])->first();

				if ($block_field['type'] != 'repeat') {

					$field->value = $field->encode_value($block_field['value'] ?? null);

				} else {

					$this->repeat($block_field['value']['fields']);

					$field->value = $field->encode_value($block_field['value']['length']);
				}

				$field->multilanguage_save();
			}			
		}
	}

	protected function repeat($block_fields) {

		foreach ($block_fields as $block_field) {

			$field = $this->model->where('id', $block_field['id'])->first();

			if ($block_field['type'] != 'repeat') {

				$func = function ($item) use (&$func, $field) {
					return is_array($item) ? array_map($func, $item) : $field->encode_value($item);
				};

				$formatted = array_map($func, $block_field['value']);
				
				$field->value = json_encode($formatted);

			} else {

				$this->repeat($block_field['value']['fields']);

				$field->value = $field->encode_value($block_field['value']['length']);
			}

			$field->multilanguage_save();
		}
	}
}