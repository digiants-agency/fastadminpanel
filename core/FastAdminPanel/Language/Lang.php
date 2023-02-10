<?php 

namespace App\FastAdminPanel\Language;

use App\FastAdminPanel\Models\Menu;
use App\FastAdminPanel\Models\Language;
use Illuminate\Http\Request;
use App;

class Lang {

	protected $lang = '';
	protected $langs = [];
	protected $host;
	protected $model;

	public function __construct(Request $request, Language $language) {
		
		$this->model = $language;
		$this->langs = $language->get();
		$this->host = $request->getHost();
		$this->lang = $this->find_lang($request, $this->langs);

		App::setLocale($this->lang);
	}

	public function url($lang, $url = '') {

		$host = $this->host;

		if ($url == '') {

			$url = url()->current();
		}

		foreach ($this->langs as $l) {

			$tag = $l->tag;

			if (strpos($url, "/$tag") == mb_strlen($url) - 3) {

				$url = str_replace("$host/$tag", $host, $url);

			} else {

				$url = str_replace("$host/$tag/", $host . '/', $url);
			}
		}

		$prefix = $this->prefix($lang);

		if ($prefix != '') {

			$prefix = '/' . $prefix;
		}

		return str_replace($host, "$host$prefix", $url);
	}

	public function get_url($lang, $url = '') {

		return $this->url($lang, $url);
	}

	public function prefix($lang = '') {

		if ($lang == '') {

			$lang = $this->lang;
		}
		
		foreach ($this->langs as $l) {

			if ($lang == $l->tag && $l->main_lang == 1) {

				return '';
			}
		}
		
		return $lang;
	}

	public function get() {

		return $this->lang;
	}

	public function tag() {

		return $this->lang;
	}

	public function main($to = '') {

		if ($to == '') {

			return $this->langs->firstWhere('main_lang', 1)->tag ?? '';
		}

		$this->model->main($to);
	}

	public function get_main() {

		return $this->main();
	}

	public function change_main($to) {

		$this->main($to);
	}

	public function langs() {

		return $this->langs;
	}

	public function all() {
		
		return $this->langs;
	}

	public function get_langs() {

		return $this->langs;
	}

	public function link($url) {

		if (mb_strpos($url, '#') === 0) {

			return $url;
		}

		$parts = parse_url($url);

		if (isset($parts['path'])) {

			$url = $parts['path'];

		} else if (isset($parts['fragment'])) {

			$url = $parts['fragment'];

		} else {

			return $url;
		}

		$lang = $this->lang;

		foreach ($this->langs as $l) {

			if ($lang == $l->tag && $l->main_lang == 1) {

				return ($url == '') ? '/' : $url;
			}
		}

		if ($url == '/')
			return "/$lang";
		return "/$lang$url";
	}

	public function ending($is_multilanguage) {

		if ($is_multilanguage) {

			return '_' . $this->lang;
		}

		return '';
	}

	protected function find_lang($request, $langs) {

		$lang = '';

		$uri = $request->path();

		$segmentsURI = explode('/', $uri);

		$main_lang = '';

		foreach ($langs as $l) {

			if ($l->tag == $segmentsURI[0] && $l->main_lang != 1) {

				$lang = $l->tag;
				
			} else if ($l->main_lang == 1) {
				
				$main_lang = $l->tag;
			}
		}

		if ($lang == '' && $main_lang != '') {

			$lang = $main_lang;
		}

		return $lang;
	}
}