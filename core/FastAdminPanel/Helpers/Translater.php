<?php

namespace App\FastAdminPanel\Helpers;


class Translater
{
	private static $imgs = [];
	private static $links = [];

	private static function encodeImages($text)
	{
		Translater::$imgs = [];

		$tags_mask = [
			' ☀ ',' 👆 ',' ☁ ',' 👇 ',' ☂ ',' 👈 ',' ✊ ',' 👉 ',' ✋ ',' 👊 ',' 👋 ',' 👌 ',' ☏ ',' ☐ ',' ☑ ',' ☒ ',' ☓ ',' ☔ ',' ☕ ',' ☖ ',' ☗ ',' ☘ ',' ☙ ',' ☚ ',
		];
		
		preg_match_all('/<img[^>]+>/', $text, $m);

		$i = 0;
		foreach ($m[0] as $img) {
			$text = str_replace($img, $tags_mask[$i], $text);
			Translater::$imgs[] = $img;
			$i++;
		}

		$text = str_replace('[block_dev]','♥',$text);
		$text = str_replace('[block_seo]','♤',$text);




		Translater::$links = [];

		$tags_mask = [
			' 😁 ',' 😂 ',' 😃 ',' 😆 ',' 😇 ',' 😈 ',' 😉 ',' 😊 ',' 😋 ',' 😌 ',' 😍 ',' 😎 ',' 😏 ',' 😐 ',' 😒 ',' 🚤 ',' 😓 ',' 😔 ',' 😖 ',' 😘 ',' 😚 ',' 😜 ',' 😝 ',' 😞 ',' 😠 ',' 😡 ',' 😢 ',' 😣 ',' 😤 ',' 😥 ',' 😨 ',' 😩 ',' 😪 ',' 😫 ',' 😭 ',' 😰 ',' 🌏 ',' 🍀 ',' 😱 ',' 😲 ',' 😳 ',' 😵 ',' 😶 ',' 😷 ',' 😸 ',' 😹 ',' 😺 ',' 😻 ',' 😼 ',' 😽 ',' 😾 ',' 😿 ',' 🙀 ',' 🙅 ',' 🙆 ',' 🙇 ',' 🙈 ',' 🙉 ',' 🙊 ',' 🙋 ',' 🙌 ',' 🙍 ',' 🙎 ',' 🐲 ',' 👀 ',' 🐝 ',' 💢 ',' ☘ ',' ✌ ',' ∞ ',' 🐾 ',' 💋 ',' 👣 ',' 🚗 ',' ☠ ',' 🚀 ',' 🚃 ',' 🚄 ',' 🚅 ',' 🚇 ',' 🚉 ',' 🚌 ',' 🚏 ',' 🚑 ',' 🚒 ',' 🚓 ',' 🚕 ',' 😄 ',' 😅 ',' 🚙 ',' 🚚 ',' 🚢 ',
		];
		
		preg_match_all('/href="[^"]+"/', $text, $m);

		$i = 0;
		foreach ($m[0] as $link) {
			$text = str_replace($link, $tags_mask[$i], $text);
			Translater::$links[] = $link;
			$i++;
		}
		

		return $text;
	}

	private static function decodeImages($text)
	{
		$tags_mask_back = [
			'☀','👆','☁','👇','☂','👈','✊','👉','✋','👊','👋','👌','☏','☐','☑','☒','☓','☔','☕','☖','☗','☘','☙','☚',
		];

		for ($i = 0, $count = count(Translater::$imgs); $i < $count; $i++) {
			$text = str_replace($tags_mask_back[$i], Translater::$imgs[$i], $text);
		}


		$tags_mask_back = [
			'😁','😂','😃','😆','😇','😈','😉','😊','😋','😌','😍','😎','😏','😐','😒','🚤','😓','😔','😖','😘','😚','😜','😝','😞','😠','😡','😢','😣','😤','😥','😨','😩','😪','😫','😭','😰','🌏','🍀','😱','😲','😳','😵','😶','😷','😸','😹','😺','😻','😼','😽','😾','😿','🙀','🙅','🙆','🙇','🙈','🙉','🙊','🙋','🙌','🙍','🙎','🐲','👀','🐝','💢','☘','✌','∞','🐾','💋','👣','🚗','☠','🚀','🚃','🚄','🚅','🚇','🚉','🚌','🚏','🚑','🚒','🚓','🚕','😄','😅','🚙','🚚','🚢',
		];

		for ($i = 0, $count = count(Translater::$links); $i < $count; $i++) {
			$text = str_replace($tags_mask_back[$i], Translater::$links[$i], $text);
		}

		
		$translation = $text;

		$translation = str_replace('  ', ' ', $translation);
		$translation = str_replace('> <', '><', $translation);
		$translation = str_replace('< /', '</', $translation);
		$translation = str_replace(' >', '>', $translation);
		$translation = str_replace('< ', '<', $translation);
		$translation = str_replace('</ ', '</', $translation);
		$translation = str_replace('/ ', '/', $translation);
		$tags = [
			'Script' => 'script',
			'Section' => 'section',
			'Div' => 'div',
			'P' => 'p',
			'Li' => 'li',
			'Ul' => 'ul',
			'Ol' => 'ol',
			'H1' => 'h1',
			'H2' => 'h2',
			'H3' => 'h3',
			'H4' => 'h4',
			'H5' => 'h5',
			'H6' => 'h6',
			'I' => 'i',
			'Strong' => 'strong',
			'A' => 'a',
			'Blockquote' => 'blockquote',
			'Figure' => 'figure',
        	'Title' => 'title',
			'Faqlist1' => 'faqlist1',
			'Faqlist2' => 'faqlist2',
		];
		foreach ($tags as $from => $to) {
			$translation = str_replace('</'.$from.'>', '</'.$to.'>', $translation);
			$translation = str_replace('<'.$from, '<'.$to, $translation);
		}
		$translation = str_replace('class = "', 'class="', $translation);
		$translation = str_replace('Digantes', 'Digiants', $translation);
		$translation = str_replace('DIGANTES', 'Digiants', $translation);
		$translation = str_replace('Digiantes', 'Digiants', $translation);
		$translation = str_replace('DIGIANTES', 'Digiants', $translation);

		
		$translation = str_replace('♥','[block_dev]',$translation);
		$translation = str_replace('♤','[block_seo]',$translation);

		return $translation;
	}
	/**
	 * @param string       $source
	 * @param string       $target
	 * @param string|array $text
	 * @param int          $attempts
	 *
	 * @return string|array With the translation of the text in the target language
	 */
	public static function translate($source, $target, $text, $attempts = 5)
	{
		// Request translation
		if (is_array($text)) {
			// Array
			$translation = self::requestTranslationArray($source, $target, $text, $attempts = 5);
		} else {
			// Single
			$translation = self::requestTranslation($source, $target, $text, $attempts = 5);
		}

		return $translation;
	}

	/**
	 * @param string $source
	 * @param string $target
	 * @param array  $text
	 * @param int    $attempts
	 *
	 * @return array
	 */
	protected static function requestTranslationArray($source, $target, $text, $attempts)
	{
		$arr = [];
		foreach ($text as $value) {
			// timeout 0.5 sec
			usleep(500000);
			$arr[] = self::requestTranslation($source, $target, $value, $attempts = 5);
		}

		return $arr;
	}

	/**
	 * @param string $source
	 * @param string $target
	 * @param string $text
	 * @param int    $attempts
	 *
	 * @return string
	 */
	protected static function requestTranslation($source, $target, $text, $attempts)
	{
	

		usleep(500000);
		// Google translate URL
		$url = 'https://translate.google.com/translate_a/single?client=at&dt=t&dt=ld&dt=qca&dt=rm&dt=bd&dj=1&hl=uk-RU&ie=UTF-8&oe=UTF-8&inputm=2&otf=2&iid=1dd3b944-fa62-4b55-b330-74909a99969e';

		if (mb_strlen($text) >= 5000) {
			throw new \Exception('Maximum number of characters exceeded: 5000');
		}

		$fields = [
			'sl' => urlencode($source),
			'tl' => urlencode($target),
			'q'  => urlencode($text),
		];

		// URL-ify the data for the POST
		$fields_string = self::fieldsString($fields);

		$content = self::curlRequest($url, $fields, $fields_string, 0, $attempts);

		if (null === $content) {
			//echo $text,' Error',PHP_EOL;
			return '';
		} else {


			// Parse translation
			$translation = self::getSentencesFromJSON($content);

			// $content = str_replace($tags_back, $tags, $content);
			$translation = str_replace('  ', ' ', $translation);
			$translation = str_replace('> <', '><', $translation);
			$translation = str_replace('< /', '</', $translation);
			$translation = str_replace(' >', '>', $translation);
			$translation = str_replace('< ', '<', $translation);
			$translation = str_replace('/ ', '/', $translation);
			$translation = str_replace('Digantes', 'Digiants', $translation);
			$translation = str_replace('DIGANTES', 'Digiants', $translation);
			$translation = str_replace('Digiantes', 'Digiants', $translation);
			$translation = str_replace('DIGIANTES', 'Digiants', $translation);

        	$tags = [
	        		'Script' => 'script',
					'Section' => 'section',
					'Div' => 'div',
        			'P' => 'p',
        			'Li' => 'li',
        			'Ul' => 'ul',
        			'Ol' => 'ol',
        			'H1' => 'h1',
        			'H2' => 'h2',
        			'H3' => 'h3',
        			'H4' => 'h4',
        			'H5' => 'h5',
        			'H6' => 'h6',
        			'I' => 'i',
        			'Strong' => 'strong',
        			'A' => 'a',
        			'Blockquote' => 'blockquote',
        			'Figure' => 'figure',
        			'Title' => 'title',
        		];
        		foreach ($tags as $from => $to) {
        			$translation = str_replace('</'.$from.'>', '</'.$to.'>', $translation);
        			$translation = str_replace('<'.$from.'>', '<'.$to.'>', $translation);
        		}
		
			return $translation;
		}
	}

	/**
	 * Dump of the JSON's response in an array.
	 *
	 * @param string $json
	 *
	 * @return string
	 */
	protected static function getSentencesFromJSON($json)
	{
		$arr = json_decode($json, true);
		$sentences = '';

		if (isset($arr['sentences'])) {
			foreach ($arr['sentences'] as $s) {
				$sentences .= isset($s['trans']) ? $s['trans'] : '';
			}
		}

		return $sentences;
	}

	/**
	 * Curl Request attempts connecting on failure.
	 *
	 * @param string $url
	 * @param array  $fields
	 * @param string $fields_string
	 * @param int    $i
	 * @param int    $attempts
	 *
	 * @return string
	 */
	protected static function curlRequest($url, $fields, $fields_string, $i, $attempts)
	{
		$i++;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_PROXY, '213.166.75.155:9964');
		// curl_setopt($ch, CURLOPT_PROXYUSERPWD, '53nV55:ggMRCx');
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');

		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if (false === $result || 200 !== $httpcode) {
			// echo $i,'/',$attempts,' Aborted, trying again... ',curl_error($ch),PHP_EOL;

			if ($i >= $attempts) {
				//echo 'Could not connect and get data.',PHP_EOL;
				return;
			//die('Could not connect and get data.'.PHP_EOL);
			} else {
				// timeout 1.5 sec
				usleep(1500000);

				return self::curlRequest($url, $fields, $fields_string, $i, $attempts);
			}
		} else {
			return $result; //self::getBodyCurlResponse();
		}
		curl_close($ch);
	}

	/**
	 * Make string with post data fields.
	 *
	 * @param array $fields
	 *
	 * @return string
	 */
	protected static function fieldsString($fields)
	{
		$fields_string = '';
		foreach ($fields as $key => $value) {
			$fields_string .= $key.'='.$value.'&';
		}

		return rtrim($fields_string, '&');
	}

	public static function tr ($content, $source, $target, $attempts = 5)
	{
		sleep(1);

		$content = Translater::encodeImages($content);

		if (mb_strlen($content) < 4000) {
			$content = Translater::translate($source, $target, $content, $attempts);
			return Translater::decodeImages($content);
		}
		
		$arraytext = array();
		while (mb_strlen($content) > 3000) {
			$tempcontent = mb_substr($content, 0, 3000);
			$dotpos = mb_strripos($tempcontent, '.');
			if ($dotpos !== FALSE) {
				$tempcontent2 = mb_substr($tempcontent, 0, $dotpos + 1);
				array_push($arraytext, $tempcontent2);
				$content = str_replace($tempcontent2, '', $content);
			} else break;
		}
		array_push($arraytext, $content);
		$result = '';
		foreach ($arraytext as $item) {
			$result .= Translater::translate($source, $target, $item, $attempts);
		}

		$result = Translater::decodeImages($result);

		return $result;
	}
}