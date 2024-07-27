<?php 

namespace App\FastAdminPanel\Helpers;

class Formatter
{
	public static function enterToBr($str)
	{
		return str_replace([PHP_EOL, "\n", "\r\n"], '<br>', $str);
	}

	public static function bracketToSpan($str)
	{
		return str_replace(["[", "]"], ['<span>', '</span>'], $str);
	}

	public static function contentImages($str)
	{
		return str_replace(["[images]", "[/images]"], ['<div class="content-images">', '</div>'], $str);
	}

	public static function phone($phone)
	{
		return preg_replace('/[^0-9\+]/', '', $phone);
	}
}