<?php 

namespace App\FastAdminPanel\Single;

use App\FastAdminPanel\Models\SinglePage;
use App\FastAdminPanel\Models\SingleField;
use App\FastAdminPanel\Single\SingleRepeated;

class Single
{
	protected $page;
	protected $fields;

	public function __construct($title, $sort, $parent = 0)
	{
		$this->page = SinglePage::where('title', $title)
		->where('parent', $parent)
		->first();

		$fields = SingleField::where('single_page_id', $this->page->id)
		->get();

		$this->fields = $this->formatFields($fields);
	}

	public function field($field_block, $field_title, $type = null, $is_multilanguage = null, $default_val = '')
	{
		$field = $this->fields[0][$field_block . $field_title];

		if ($field->type == 'repeat') {

			return new SingleRepeated($this->fields, $field->id, intval($field->value), []);
		}

		return $field->decodeValue($field->value);
	}

	protected function formatFields($fields)
	{
		$blocks = [];

		foreach ($fields as $field) {

			if (empty($blocks[$field->parent_id])) {

				$blocks[$field->parent_id] = [];
			}

			$blocks[$field->parent_id][$field->block_title . $field->title] = $field;
		}

		return $blocks;
	}
}