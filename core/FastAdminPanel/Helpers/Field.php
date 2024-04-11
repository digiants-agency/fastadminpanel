<?php 

namespace App\FastAdminPanel\Helpers;

class Field
{
	public static function default($type)
	{
		return match($type) {
			'text'			=> '',
			'textarea'		=> '',
			'ckeditor'		=> '',
			'checkbox'		=> 0,
			'color'			=> '#000000',
			'date'			=> date('Y-m-d'),
			'datetime'		=> date('Y-m-d H:i:s'),
			'relationship'	=> 0,
			'file'			=> '',
			'photo'			=> '',
			'gallery'		=> [],
			'password'		=> '',
			'money'			=> 0,
			'number'		=> 0,
			'enum'			=> '',
			// 'repeat'		=> '',
			default			=> '',
		};
	}

	public static function enterToBr($str)
	{
		return str_replace([PHP_EOL, "\n"], '<br>', $str);
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