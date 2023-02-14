<?php 

namespace App\FastAdminPanel\Single\Saver;

use App\FastAdminPanel\Models\SingleField;
use Lang;

class SingleRepeated
{
	protected $single_page_id;
	protected $parent_id;
	protected $is_multilanguage;

	protected $sorts = [];
	protected $sort = 1;

	public function __construct($single_page_id, $parent_id, $is_multilanguage)
	{

		$this->single_page_id = $single_page_id;
		$this->parent_id = $parent_id;
		$this->is_multilanguage = $is_multilanguage;
	}

	public function field($field_title, $type)
	{
		$this->sorts[$field_title] = $this->sort;
		$this->sort++;

		$field = SingleField::where('single_page_id', $this->single_page_id)
		->where('block_title', '')
		->where('title', $field_title)
		->where('parent_id', $this->parent_id)
		->first();

		foreach (Lang::all() as $lang) {

			$field_lang = new SingleField($lang->tag);

			if (empty($field)) {

				$field_lang->title			= $field_title;
				$field_lang->block_title	= '';
				$field_lang->single_page_id	= $this->single_page_id;
				$field_lang->parent_id		= $this->parent_id;

			} else {

				$field_lang = $field_lang->where('single_page_id', $this->single_page_id)
				->where('block_title', '')
				->where('title', $field_title)
				->where('parent_id', $this->parent_id)
				->first();
			}

			$field_lang->is_multilanguage	= $this->is_multilanguage;
			$field_lang->type				= $type;
			$field_lang->sort				= $this->sorts[$field_title];

			$field_lang->save();
		}

		if ($type == 'repeat') {

			return [new SingleRepeated($this->single_page_id, $field_lang->id, $this->is_multilanguage)];
		}

		return $field_lang->savedMsg();
	}
}