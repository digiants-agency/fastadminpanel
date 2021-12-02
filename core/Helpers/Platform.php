<?php 

namespace App\FastAdminPanel\Helpers;

use Agent;

class Platform {

	private static $is_mobile = null;

	public static function init () {

		if (self::$is_mobile === null) {
			if (Agent::isMobile() && !Agent::isTablet()) {
				self::$is_mobile = true;
			} else {
				self::$is_mobile = false;
			}
		}
	}

	public static function mobile () {

		self::init();

		return self::$is_mobile;
	}

	public static function desktop () {

		self::init();

		return !self::$is_mobile;
	}

	public static function tablet () {

		return Agent::isTablet();
	}

	public static function iphone () {

		return isset($_SERVER['HTTP_USER_AGENT']) && mb_strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false;
	}

	public static function safari () {

		return isset($_SERVER['HTTP_USER_AGENT']) && mb_strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== false;
	}
}