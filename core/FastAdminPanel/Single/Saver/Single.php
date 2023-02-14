<?php 

namespace App\FastAdminPanel\Single\Saver;

use App\FastAdminPanel\Models\SinglePage;
use App\FastAdminPanel\Models\SingleField;
use Lang;

class Single
{
	protected $page;

	protected $sorts = [];

	public function __construct($title, $sort, $parent = 0)
	{
		$this->page = SinglePage::where('title', $title)->first();

		if (empty($this->page)) {

			$this->page = new SinglePage();

			$this->page->title = $title;
		}

		$this->page->sort	= $sort;
		$this->page->parent	= $parent;

		$this->page->save();
	}

	public function field($field_block, $field_title, $type = null, $is_multilanguage = null, $default_val = null)
	{
		if ($type === null || $is_multilanguage === null) {

			return 'NOT saved';
		}

		if (empty($this->sorts[$field_block]))
			$this->sorts[$field_block] = 0;

		$this->sorts[$field_block]++;

		$field = SingleField::where('single_page_id', $this->page->id)
		->where('block_title', $field_block)
		->where('title', $field_title)
		->where('parent_id', 0)
		->first();

		foreach (Lang::all() as $lang) {

			$field_lang = new SingleField($lang->tag);

			if (empty($field)) {

				$field_lang->title			= $field_title;
				$field_lang->block_title	= $field_block;
				$field_lang->single_page_id	= $this->page->id;
				$field_lang->parent_id		= 0;

			} else {

				$field_lang = $field_lang->where('single_page_id', $this->page->id)
				->where('block_title', $field_block)
				->where('title', $field_title)
				->where('parent_id', 0)
				->first();

				if ($type != $field_lang->type && $type != 'repeat') {

					$field_lang->value = $field_lang->encodeValue($default_val ?? $field_lang->default());
				}
			}

			$field_lang->is_multilanguage	= $is_multilanguage;
			$field_lang->type				= $type;
			$field_lang->sort				= $this->sorts[$field_block];

			if (empty($field) && $type != 'repeat') {

				$field_lang->value = $field_lang->encodeValue($default_val ?? $field_lang->default());
			}

			$field_lang->save();
		}

		if ($type == 'repeat') {

			return [new SingleRepeated($this->page->id, $field_lang->id, $is_multilanguage)];
		}

		return $field_lang->savedMsg();
	}
}