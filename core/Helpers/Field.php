<?php 

namespace App\FastAdminPanel\Helpers;

use DB;

class Field {

	public static function enter_to_br ($str) {
		return str_replace("\n", '<br>', str_replace('
', '<br>', $str));
	}

	public static function phone ($phone) {
		return preg_replace('/[^0-9\+]/', '', $phone);
	}
}