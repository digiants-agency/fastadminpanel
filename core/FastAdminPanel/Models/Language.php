<?php

namespace App\FastAdminPanel\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
	public $timestamps = false;

	protected $table = 'languages';

	protected $fillable = [
		'tag',
		'main_lang',
	];

	public static function boot()
	{
		parent::boot();

		static::deleting(function($lang) {

			$menu = new Menu();
			$menu->removeTables($lang->tag);
			
			$field = new SingleField();
			$field->removeTables($lang->tag);
		});

		static::creating(function($lang) {

			$main = Language::select('tag')->where('main_lang', 1)->first();

			$menu = new Menu();
			$menu->addTables($lang->tag, $main->tag);
			
			$field = new SingleField();
			$field->addTables($lang->tag, $main->tag);
		});
	}
}