<?php

namespace Digiants\FastAdminPanel\Publishers;

class Provider
{
	public function publish()
	{
		$provider = file_get_contents(base_path("/bootstrap/app.php"));
		$hasClass = strpos($provider, 'FastAdminPanelServiceProvider::class');
		
		if ($hasClass === false) {

			$newProvider = str_replace("return [", "return [\nApp\FastAdminPanel\Providers\FastAdminPanelServiceProvider::class,", $provider);
			
			file_put_contents(
				base_path("/bootstrap/app.php"),
				$newProvider
			);
		}
	}
}