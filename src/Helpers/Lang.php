<?php 

namespace Digiants\FastAdminPanel\Helpers;

use DB;
use Request;
use App;

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

	public static function get_langs () {

		if (count(Lang::$langs) == 0) {

			Lang::$langs = DB::table('languages')->get();
		}
		return Lang::$langs;
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
}