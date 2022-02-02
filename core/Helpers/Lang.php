<?php 

namespace App\FastAdminPanel\Helpers;

use DB;
use Request;
use App;
use Schema;

class Lang {

	private static $lang = '';
	private static $langs = [];

	public static function get_url ($lang, $url = '') {

		$langs = Lang::get_langs();
		$host = Request::getHost();

		if ($url == '')
			$url = url()->current();

		foreach ($langs as $l) {

			$tag = $l->tag;

			if (strpos($url, "/$tag") == mb_strlen($url) - 3) {

				$url = str_replace("$host/$tag", $host, $url);

			} else {

				$url = str_replace("$host/$tag/", $host.'/', $url);
			}
		}

		$prefix = Lang::prefix($lang);
		if ($prefix != '')
			$prefix = '/'.$prefix;

		return str_replace($host, "$host$prefix", $url);
	}

	public static function prefix ($lang = '') {

		if ($lang == '')
			$lang = Lang::get();
		
		$langs = Lang::get_langs();

		foreach ($langs as $l) {

			if ($lang == $l->tag && $l->main_lang == 1)
				return '';
		}
		
		return $lang;
	}

	public static function get () {

		if (Lang::$lang == '') {

			$langs = Lang::get_langs();
		
			$uri = Request::path(); // получаем URI 

			$segmentsURI = explode('/', $uri); // делим на части по разделителю "/"

			$main_lang = '';

			foreach ($langs as $l) {

				if ($l->tag == $segmentsURI[0] && $l->main_lang != 1) {

					Lang::$lang = $l->tag;
					
				} else if ($l->main_lang == 1) {
					
					$main_lang = $l->tag;
				}
			}

			if (Lang::$lang == '' && $main_lang != '')
				Lang::$lang = $main_lang;

			App::setLocale(Lang::$lang);
		}

		return Lang::$lang;
	}

	public static function get_main () {

		if (empty(Lang::$langs)) {

			return DB::table('languages')->where('main_lang', 1)
			->first()->tag;
		}

		return Lang::$langs->where('main_lang', 1)->first()->tag;
		
	}

	public static function change_main($to) {

		DB::table('languages')
		->update([
			'main_lang'	=> 0,
		]);

		DB::table('languages')->where('tag', $to)
		->update([
			'main_lang'	=> 1,
		]);
		
	}

	public static function get_langs () {

		if (count(Lang::$langs) == 0) {

			Lang::$langs = DB::table('languages')->get();
		}
		return Lang::$langs;
	}

	public static function all () {
		
		return self::get_langs();
	}

	public static function link ($url) {

		if (mb_strpos($url, '#') === 0)
			return $url;

		$parts = parse_url($url);
		if (isset($parts['path'])) {
			$url = $parts['path'];
		} else if (isset($parts['fragment'])) {
			$url = $parts['fragment'];
		} else {
			return $url;
		}

		$lang = Lang::get();
		$langs = Lang::get_langs();

		foreach ($langs as $l) {

			if ($lang == $l->tag && $l->main_lang == 1)
				return ($url == '') ? '/' : $url;
		}

		if ($url == '/')
			return "/$lang";
		return "/$lang$url";
	}

	public static function ending ($is_multilanguage) {

		if ($is_multilanguage)
			return '_'.Lang::get();
		return '';
	}

	public static function add ($tag) {

		$tag = mb_strtolower($tag);

		if (empty($tag) || mb_strlen($tag) != 2)
			return 'Invalid tag';

		$lang = DB::table('languages')
		->where('tag', $tag)
		->first();

		if (!empty($lang))
			return 'Language have already exist';

		$main_tag = DB::table('languages')
		->where('main_lang', 1)
		->first()
		->tag;

		DB::table('languages')
		->insert([
			'tag'		=> $tag,
			'main_lang'	=> 0,
		]);

		$menu = DB::table('menu')->get();

		foreach ($menu as $elm) {
			if ($elm->multilanguage == 1) {
				Schema::dropIfExists("{$elm->table_name}_$tag");
				DB::statement("CREATE TABLE {$elm->table_name}_$tag LIKE {$elm->table_name}_$main_tag");
				DB::statement("INSERT {$elm->table_name}_$tag SELECT * FROM {$elm->table_name}_$main_tag");
			}
		}

		Single::add_db($tag, $main_tag);
	}

	public static function remove($tag){

		$tag = mb_strtolower($tag);

		$lang = DB::table('languages')
		->where('tag', $tag)
		->where('main_lang', '!=', 1)
		->first();

		if (empty($lang))
			return 'Language doesnt exist or you try delete main language';

		$menu = DB::table('menu')->get();

		foreach ($menu as $elm) {
			if ($elm->multilanguage == 1) {
				Schema::dropIfExists("{$elm->table_name}_$tag");
			}
		}

		DB::table('languages')
		->where('tag', $tag)
		->delete();

		Single::rm_db($tag);
	}

}