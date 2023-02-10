<?php

namespace App\FastAdminPanel\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {
	
	public $timestamps = false;

	protected $table = 'languages';

	protected $fillable = [
		'tag',
		'main_lang',
	];

	public static function boot() {
		parent::boot();

		static::deleting(function($lang) {

			$menu = new Menu();
			$menu->remove_tables($lang->tag);
			
			$field = new SingleField();
			$field->remove_tables($lang->tag);
		});

		static::creating(function($lang) {

			$main = Language::select('tag')->where('main_lang', 1)->first();

			$menu = new Menu();
			$menu->add_tables($lang->tag, $main->tag);
			
			$field = new SingleField();
			$field->add_tables($lang->tag, $main->tag);
		});
	}

	// public function fullfill_table($console) {

	// 	$count = $console->ask('Languages count');

	// 	if ($count > 0) {

	// 		for ($i = 1; $i <= $count; $i++) {

	// 			$this->create([
	// 				'tag'		=> $console->ask("Language tag number $i"),
	// 				'main_lang'	=> 0,
	// 			]);
	// 		}

	// 		$tags = $this->select('tag')->get()->pluck('tag');
	// 		$main_tag = $console->choice('Enter main language tag', $tags, 0);

	// 		$this->where('tag', $main_tag)
	// 		->update([
	// 			'main_lang'	=> 1,
	// 		]);

	// 	} else {

	// 		throw new \Exception("There are no languages created!");
	// 	}
	// }
}