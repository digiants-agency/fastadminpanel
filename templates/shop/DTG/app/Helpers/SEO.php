<?php  

namespace App\Helpers;

class SEO {

	private static $robots = '';
	private static $href_prev = '';
	private static $href_next = '';
	
	public static function robots ($robots = -1) {

		if ($robots != -1)
			self::$robots = $robots;

		if (self::$robots == '') return '';
		return '<meta name="robots" content="' . self::$robots . '"/>';
	}


	public static function link_prev($href_prev = -1) {

		if ($href_prev != -1)
			self::$href_prev = $href_prev;

		if (self::$href_prev == '') return '';

		return '<link rel="prev" href="'.self::$href_prev.'">';
	}

    public static function link_next($href_next = -1) {

		if ($href_next != -1)
			self::$href_next = $href_next;

		if (self::$href_next == '') return '';

		return '<link rel="next" href="'.self::$href_next.'">';
	}

}