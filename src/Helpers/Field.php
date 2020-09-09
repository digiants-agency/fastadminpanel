<?php 

namespace Digiants\FastAdminPanel\Helpers;

use DB;

class Field {

	public static function enter_to_br ($str) {
		return str_replace("\n", '<br>', str_replace('
', '<br>', $str));
	}
}