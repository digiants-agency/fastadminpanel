<?php 

namespace App\FastAdminPanel\Single\Api;

class Getter {

	protected $fields;
	protected $formatted_fields;

	public function __construct($model, $page_id) {

		$this->fields = $model->where('single_page_id', $page_id)
		->orderBy('sort', 'ASC')
		->get();

		$this->formatted_fields = $this->format_fields($this->fields);
	}

	public function get() {

		$blocks = [];

		foreach ($this->formatted_fields[0] as $field) {

			if ($field->type != 'repeat') {

				$value = $field->decode_value($field->value);

			} else {

				$value = $this->repeat([], $field->decode_value($field->value), $field->id);
			}

			if (empty($blocks[$field->block_title])) {

				$blocks[$field->block_title] = [];
			}

			$blocks[$field->block_title][] = [
				'id'				=> $field->id,
				'title'				=> $field->title,
				'type'				=> $field->type,
				'value'				=> $value,
			];
		}

		return $blocks;
	}

	protected function repeat($fields, $length, $parent_id) {

		foreach ($this->formatted_fields[$parent_id] as $field) {

			if ($field->type != 'repeat') {

				$value = json_decode($field->value);

				$this->repair_fields_by_dfs($value, $length);

				$func = function ($item) use (&$func, $field) {
					return is_array($item) ? array_map($func, $item) : $field->decode_value($item);
				};

				$value = array_map($func, $value);

			} else {

				$value = $this->repeat([], $field->decode_value($field->value), $field->id);
			}

			$fields[] = [
				'id'				=> $field->id,
				'title'				=> $field->title,
				'type'				=> $field->type,
				'value'				=> $value,
			];
		}

		return [
			'fields'	=> $fields,
			'length'	=> $length,
		];
	}

	protected function repair_fields_by_dfs(&$value, &$length) {

		if (is_numeric($length) && (!is_array($value) || count($value) != $length)) {

			$value = array_fill(0, $length, "");
			return;

		} else if (!is_numeric($length)) {

			for ($i = 0; $i < count($length); $i++) {

				if (is_array($length[$i])) {
	
					$this->repair_fields_by_dfs($value[$i], $length[$i]);
	
				} else if (!is_array($value[$i]) || count($value[$i]) != $length[$i]) {
	
					$value[$i] = array_fill(0, $length[$i], "");
				}
			}
		}
	}

	protected function format_fields($fields) {

		$blocks = [];

		foreach ($fields as $field) {

			if (empty($blocks[$field->parent_id])) {

				$blocks[$field->parent_id] = [];
			}

			$blocks[$field->parent_id][] = $field;
		}

		return $blocks;
	}
}