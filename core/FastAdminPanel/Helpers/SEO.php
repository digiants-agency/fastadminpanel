<?php  

namespace App\FastAdminPanel\Helpers;

// TODO: make service + facade singleton
class SEO
{
	private static $robots = '';
	private static $hrefPrev = '';
	private static $hrefNext = '';
	
	public static function robots($robots = -1)
	{
		if ($robots != -1)
			self::$robots = $robots;

		if (self::$robots == '') return '';
		return '<meta name="robots" content="' . self::$robots . '"/>';
	}

	public static function linkPrev($hrefPrev = -1)
	{
		if ($hrefPrev != -1)
			self::$hrefPrev = $hrefPrev;

		if (self::$hrefPrev == '') return '';

		return '<link rel="prev" href="'.self::$hrefPrev.'">';
	}

    public static function linkNext($hrefNext = -1)
	{
		if ($hrefNext != -1)
			self::$hrefNext = $hrefNext;

		if (self::$hrefNext == '') return '';

		return '<link rel="next" href="'.self::$hrefNext.'">';
	}
}