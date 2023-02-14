<?php 

namespace App\FastAdminPanel\Single;

use App\FastAdminPanel\Single\SingleRepeatedFields;

class SingleRepeated implements \Iterator
{
	protected $fields;
	protected $parent_id;
	protected $pointer;

	protected $position = 0;
	protected $length = 0;

	public function __construct($fields, $parent_id, $length, $pointer)
	{
		$this->fields = $fields;
		$this->parent_id = $parent_id;
		$this->pointer = $pointer;
		$this->length = $length;
	}

	public function current()
	{
		$current_pointer = $this->pointer;
		$current_pointer[] = $this->position;

		return new SingleRepeatedFields($this->fields, $this->parent_id, $current_pointer);
	}

	public function key()
	{
		return $this->position;
	}

	public function next()
	{
		$this->position++;
	}

	public function rewind()
	{
		$this->position = 0;
	}

	public function valid()
	{
		return $this->position < $this->length;
	} 
}