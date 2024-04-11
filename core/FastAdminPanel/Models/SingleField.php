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

class SingleField extends MultilanguageModel
{
	public $timestamps = false;

	protected $table = 'single_fields';

	protected $fillable = [
		'id',
		'is_multilanguage',
		'type',
		'title',
		'slug',
		'single_block_id',
		'sort',
		'parent_id',
		'value',
	];

	protected $attributes = [
		'value'	=> '',
	];

	public function multilanguageSave()
	{
		if ($this->is_multilanguage == 0) {
	
			$langs = Lang::all();

			foreach ($langs as $lang) {

				// TODO: probably, I should add function to change table
				$model = new SingleField($lang->tag);

				$field = $model->where('id', $this->id)->first();

				$field->is_multilanguage = $this->is_multilanguage;
				$field->type = $this->type;
				$field->title = $this->title;
				$field->slug = $this->slug;
				$field->single_block_id = $this->single_block_id;
				$field->sort = $this->sort;
				$field->parent_id = $this->parent_id;
				$field->value = $this->value;

				$field->save();
			}

		} else {

			$this->save();
		}
	}

	public function encodeValue($value)
	{
		$value = $value === null ? $this->default() : $value;

		return match($this->type) {
			'repeat'		=> json_encode($value, JSON_UNESCAPED_UNICODE),
			'checkbox'		=> $value ? 1 : 0,
			'gallery'		=> json_encode($value, JSON_UNESCAPED_UNICODE),
			default			=> $value,
		};
	}

	public function decodeValue($value)
	{
		return match($this->type) {
			'repeat'		=> json_decode($value) ?? 0,
			'checkbox'		=> !!$value,
			'gallery'		=> json_decode($value) ?? [],
			'money'			=> floatval($value),
			'number'		=> intval($value),
			default			=> $value,
		};
	}

	public function default()
	{
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

	public function defaults($length)
	{
		$vals = [];

		for ($i = 0; $i < $length; $i++) {

			$vals[] = $this->default();
		}

		return $vals;
	}

	public function savedMsg()
	{
		return match($this->type) {
			'checkbox'		=> false,
			'date'			=> date('Y-m-d'),
			'datetime'		=> date('Y-m-d H:i:s'),
			'gallery'		=> [],
			default			=> 'Saved',
		};
	}

	public function childrenFields()
	{
		return $this->hasMany(SingleField::class, 'parent_id');
	}

	public function fields()
	{
		return $this->childrenFields()->with('fields');
	}

	public function removeTables($tag)
	{
		$table = substr($this->table, 0, -2);

		Schema::dropIfExists("{$table}{$tag}");
	}

	public function addTables($tag, $main_tag)
	{
		$table = substr($this->table, 0, -2);
				
		Schema::dropIfExists("{$table}{$tag}");
		DB::statement("CREATE TABLE {$table}{$tag} LIKE {$table}{$main_tag}");
		DB::statement("INSERT {$table}{$tag} SELECT * FROM {$table}{$main_tag}");
	}
}