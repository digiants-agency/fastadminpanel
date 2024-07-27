<?php 

namespace App\FastAdminPanel\Services;

use Detection\MobileDetect;

class PlatformService
{
	protected $isMobile = null;
	protected $isTablet = null;

	public function __construct()
	{
		$detect = new MobileDetect();
		
		if ($detect->isMobile() && !$detect->isTablet()) {
			$this->isMobile = true;
		} else {
			$this->isMobile = false;
		}

		$this->isTablet = $detect->isTablet();
	}

	public function mobile()
	{
		return $this->isMobile;
	}

	public function desktop()
	{
		return !$this->isMobile;
	}

	public function tablet()
	{
		return $this->isTablet;
	}

	public function iphone()
	{
		return isset($_SERVER['HTTP_USER_AGENT']) && mb_strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false;
	}

	public function safari()
	{
		return isset($_SERVER['HTTP_USER_AGENT']) && mb_strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== false;
	}
}