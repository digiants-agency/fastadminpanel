<?php 

namespace App\FastAdminPanel\Helpers;

use Detection\MobileDetect;

class Platform
{
	private static $is_mobile = null;

	public static function init()
	{
		$detect = new MobileDetect();
		
		if (self::$is_mobile === null) {
			if ($detect->isMobile() && !$detect->isTablet()) {
				self::$is_mobile = true;
			} else {
				self::$is_mobile = false;
			}
		}
	}

	public static function mobile()
	{
		self::init();

		return self::$is_mobile;
	}

	public static function desktop()
	{
		self::init();

		return !self::$is_mobile;
	}

	public static function tablet()
	{
		$detect = new MobileDetect();
		return $detect->isTablet();
	}

	public static function iphone()
	{
		return isset($_SERVER['HTTP_USER_AGENT']) && mb_strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false;
	}

	public static function safari()
	{
		return isset($_SERVER['HTTP_USER_AGENT']) && mb_strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== false;
	}
}