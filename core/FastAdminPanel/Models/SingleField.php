<?php

namespace App\FastAdminPanel\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Schema;
use Lang;
use DB;

// types:
// text
// textarea
// ckeditor
// checkbox
// color
// date
// datetime
// relationship
// file
// photo
// gallery
// password
// money
// number
// enum
// repeat

class SingleField extends MultilanguageModel {
	
	public $timestamps = false;

	protected $table = 'single_fields';

	public function multilanguage_save() {

		if ($this->is_multilanguage == 0) {
	
			$langs = Lang::all();

			foreach ($langs as $lang) {

				// TODO: probably, I should add function to change table
				$model = new SingleField($lang->tag);

				$field = $model->where('id', $this->id)->first();

				$field->is_multilanguage = $this->is_multilanguage;
				$field->type = $this->type;
				$field->title = $this->title;
				$field->block_title = $this->block_title;
				$field->single_page_id = $this->single_page_id;
				$field->sort = $this->sort;
				$field->parent_id = $this->parent_id;
				$field->value = $this->value;

				$field->save();
			}

		} else {

			$this->save();
		}
	}

	public function encode_value($value) {

		$value = $value === null ? $this->default() : $value;

		return match($this->type) {
			'repeat'		=> json_encode($value),
			'checkbox'		=> $value ? 1 : 0,
			'gallery'		=> json_encode($value, JSON_UNESCAPED_UNICODE),
			default			=> $value,
		};
	}

	public function decode_value($value) {

		return match($this->type) {
			'repeat'		=> json_decode($value) ?? 0,
			'checkbox'		=> !!$value,
			'gallery'		=> json_decode($value) ?? [],
			'money'			=> intval($value),
			'number'		=> intval($value),
			default			=> $value,
		};
	}

	public function default() {

		return match($this->type) {
			'text'			=> '',
			'textarea'		=> '',
			'ckeditor'		=> '',
			'checkbox'		=> false,
			'color'			=> '#000000',
			'date'			=> date('Y-m-d'),
			'datetime'		=> date('Y-m-d H:i:s'),
			// 'relationship'	=> '',
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

	public function defaults($length) {

		$vals = [];

		for ($i = 0; $i < $length; $i++) {

			$vals[] = $this->default();
		}

		return $vals;
	}

	public function saved_msg() {

		return match($this->type) {
			'checkbox'		=> false,
			'date'			=> date('Y-m-d'),
			'datetime'		=> date('Y-m-d H:i:s'),
			'gallery'		=> [],
			default			=> 'Saved',
		};
	}

	public function remove_tables($tag) {

		$table = substr($this->table, 0, -2);

		Schema::dropIfExists("{$table}{$tag}");
	}

	public function add_tables($tag, $main_tag) {

		$table = substr($this->table, 0, -2);
				
		Schema::dropIfExists("{$table}{$tag}");
		DB::statement("CREATE TABLE {$table}{$tag} LIKE {$table}{$main_tag}");
		DB::statement("INSERT {$table}{$tag} SELECT * FROM {$table}{$main_tag}");
	}
}