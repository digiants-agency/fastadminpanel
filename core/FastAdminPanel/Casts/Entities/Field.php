<?php

namespace App\FastAdminPanel\Casts\Entities;

// TODO: divide so much responsibility
class Field implements \JsonSerializable
{
	protected $field;

	public function __construct($field)
	{
		$this->field = is_string($field) ? json_decode($field) : (object)$field;
	}

	public function __get($name)
	{
		return $this->field->$name;
	}

	public function __set($name, $value)
	{
		return $this->field->$name = $value;
	}

	public function default()
	{
		return match($this->field->type) {
			'text'			=> '',
			'textarea'		=> '',
			'ckeditor'		=> '',
			'checkbox'		=> 0,
			'color'			=> '#000000',
			'date'			=> date('Y-m-d'),
			'datetime'		=> date('Y-m-d H:i:s'),
			'relationship'	=> 0,
			'file'			=> '',
			'photo'			=> '',
			'gallery'		=> [],
			'password'		=> '',
			'money'			=> 0,
			'number'		=> 0,
			'enum'			=> '',
			// 'repeat'		=> '',
			default			=> '',
		};
	}

	public function getDbTitle()
	{
		if ($this->field->type == 'relationship') {
				
			if ($this->field->relationship_count == 'single') {

				return "id_{$this->field->relationship_table_name}";
			}

		} else {

			return $this->field->db_title;
		}
		
		return false;
	}

	public function jsonSerialize() : mixed
	{
		return $this->field;
	}

	public function getFillable()
	{
		if (in_array($this->field->type, ['password'])) {

			return false;
		}

		if ($this->field->type == 'relationship') {
                
			if ($this->field->relationship_count == 'single') {

				return "id_".$this->field->relationship_table_name;
			}

			return false;
		}

		return $this->field->db_title;
	}

	public function isSearchable()
	{
		$types = ['text', 'textarea', 'ckeditor', 'date', 'datetime', 'money', 'number', 'enum'];

		if (in_array($this->field->type, $types) && $this->field->show_in_list != 'no') {

			return true;
		}

		return false;
	}

	public function isCommon()
	{
		return $this->lang == 0;
	}

	public function isSeparate()
	{
		return $this->lang == 1;
	}
}