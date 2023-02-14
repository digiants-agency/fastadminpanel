<?php 

namespace App\FastAdminPanel\Helpers;

use DB;

class Field
{
	public static function bracketToSpan($str)
	{
		return str_replace("[", '<span>', str_replace(']', '</span>', $str));
	}

	public static function contentImages($str)
	{
		return str_replace("[images]", '<div class="content-images">', str_replace('[/images]', '</div>', $str));
	}

	public static function phone($phone)
	{
		return preg_replace('/[^0-9\+]/', '', $phone);
	}
}