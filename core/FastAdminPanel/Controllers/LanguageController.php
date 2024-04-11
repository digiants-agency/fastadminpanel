<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Language;

class LanguageController extends \App\Http\Controllers\Controller
{
	public function delete($tag)
	{
		$lang = Language::where('tag', $tag)
		->where('main_lang', '!=', 1)
		->first();

		if (!empty($lang)) {

			$lang->delete();
		}

		return $this->response();
	}

	public function post($tag)
	{
		$lang = Language::where('tag', $tag)->first();

		if (empty($lang) && strlen($tag) == 2) {

			Language::create([
				'tag'		=> $tag,
				'main_lang'	=> 0,
			]);
		}

		return $this->response();
	}
}