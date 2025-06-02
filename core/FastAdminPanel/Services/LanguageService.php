<?php 

namespace App\FastAdminPanel\Services;

use App\FastAdminPanel\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageService
{
	protected $lang = '';
	protected $langs = [];
	protected $host;

	public function __construct(Request $request)
	{
		try {

			$this->langs = Language::get();

		} catch (\Exception $e) { // for migrate purpose
			
			if (App::runningInConsole()) {
				echo 'Warning! Cant connect to db or table languages doesnt exist', PHP_EOL;
			}

			$this->langs = collect([
				(object)[
					'id'		=> 1,
					'tag'		=> 'en',
					'main_lang'	=> 1,
				],
			]);
		}
		
		$this->host = $request->getHost();
		$this->lang = $this->findLang($request, $this->langs);

		App::setLocale($this->lang);
	}

	public function url($lang, $url = '')
	{
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

	public function getUrl($lang, $url = '')
	{
		return $this->url($lang, $url);
	}

	public function is($lang)
	{
		return $this->lang == $lang;
	}

	public function prefix($lang = '', $prefix = '')
	{
		if ($lang == '') {

			$lang = $this->lang;
		}
		
		foreach ($this->langs as $l) {

			if ($lang == $l->tag && $l->main_lang == 1) {

				$lang = '';
			}
		}

		if ($prefix) {

			if ($lang) {

				return "$lang/$prefix";
			}

			return $prefix;
		}
		
		return $lang;
	}

	public function get()
	{
		return $this->lang;
	}

	public function tag()
	{
		return $this->lang;
	}

	public function main($to = '')
	{
		if ($to == '') {

			return $this->langs->firstWhere('main_lang', 1)->tag ?? '';
		}

		Language::where('main_lang', 1)
		->update([
			'main_lang'	=> 0,
		]);

		Language::where('tag', $to)
		->update([
			'main_lang'	=> 1,
		]);
	}

	public function isMain()
	{
		return $this->main() == $this->lang;
	}

	public function getMain()
	{
		return $this->main();
	}

	public function changeMain($to)
	{
		$this->main($to);
	}

	public function langs()
	{
		return $this->langs;
	}

	public function all()
	{
		return $this->langs;
	}

	public function getLangs()
	{
		return $this->langs;
	}

	public function count()
	{
		return $this->langs->count();
	}

	public function link($url)
	{
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

	public function ending($isMultilanguage)
	{
		if ($isMultilanguage) {

			return '_' . $this->lang;
		}

		return '';
	}

	protected function findLang($request, $langs)
	{
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