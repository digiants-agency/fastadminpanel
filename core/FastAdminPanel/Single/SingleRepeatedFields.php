<?php 

namespace App\FastAdminPanel\Single;

use App\FastAdminPanel\Single\SingleRepeated;

class SingleRepeatedFields
{
	protected $fields;
	protected $parent_id;
	protected $pointer;

	public function __construct($fields, $parent_id, $pointer)
	{
		$this->fields = $fields;
		$this->parent_id = $parent_id;
		$this->pointer = $pointer;
	}

	public function field($field_title, $type = '')
	{
		$field = $this->fields[$this->parent_id][$field_title];

		$value = json_decode($field->value);

		foreach ($this->pointer as $index) {

			$value = $value[$index] ?? '';
		}

		if ($field->type == 'repeat') {

			return new SingleRepeated($this->fields, $field->id, intval($value), $this->pointer);
		}

		return $field->decodeValue($value);
	}
}