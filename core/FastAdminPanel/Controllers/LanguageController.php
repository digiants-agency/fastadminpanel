<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends \App\Http\Controllers\Controller {

	public function delete(Language $model, $tag) {

		$lang = $model->where('tag', $tag)
		->where('main_lang', '!=', 1)
		->first();

		if (!empty($lang)) {

			$lang->delete();
		}

		return $this->response();
	}

	public function post(Language $model, $tag) {

		$lang = $model->where('tag', $tag)->first();

		if (empty($lang) && strlen($tag) == 2) {

			$model->create([
				'tag'		=> $tag,
				'main_lang'	=> 0,
			]);
		}

		return $this->response();
	}
}